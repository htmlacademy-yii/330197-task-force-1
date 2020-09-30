<?php
declare(strict_types=1);

/*
 * TODO: validate data - check data format
 * TODO: set data properties
 * TODO: compose and execute query
 * TODO: escape data
 * DONE: validate data - check data existance
 */

namespace frontend\models\src;

use Yii;
use yii\base\Module;
use frontend\models\Tasks;
use frontend\models\Categories;
use frontend\functions;

class TasksSearch extends Module {

    public function parse_data($form_data){
        if($form_data['categories']){
            $form_data['categories'] = implode(",",$form_data['categories']);
        }
        if($form_data['no_executers']){
            $form_data['no_executers'] = true;
        }
        if($form_data['no_address']){
            $form_data['no_address'] = true;
        }
        if($form_data['period']){
            switch ($form_data['period']) {
                case 'day':
                    $form_data['period'] = date('Y-m-d',time()-86400);
                    break;
                case 'week':
                    $form_data['period'] = date('Y-m-d',time()-86400*7);
                    break;
                case 'month':
                    $form_data['period'] = date('Y-m-d',time()-86400*30);
                    break;
                default:
                    $form_data['period'] = false;
                    break;
            }
        }
        if($form_data['find']){
            $form_data['find'] = $form_data['find'];
        }
        return $form_data;
    }

    public function search($form_data = null){
        $query = Tasks::find()->select(['t.title','t.description','t.budget','t.address','t.dt_add','t.deadline','t.idcategory as id'])->from(['tasks t'])->where("current_status = 'new'");
        //Подключаем переданные фильтры через форму
        if($form_data['categories']){
            $query = $query->andWhere("t.idcategory in (".$form_data['categories'].")");
        }
        if($form_data['no_executers']){
            $query = $query->andWhere("t.id not in (select distinct idtask from responds)");
        }
        if($form_data['no_address']){
            $query = $query->andWhere("t.latitude is null or t.longitude is null");
        }
        if($form_data['period']){
            $query = $query->andWhere("date(dt_add) >= date('".$form_data['period']."')");
        }
        if($form_data['find']){
            $query = $query->andWhere("MATCH(title) AGAINST('*".$form_data['find']."*' in boolean mode)");
        }

        $query = $query->orderBy(['t.dt_add' => SORT_DESC])->limit(5);
        $rows = $query->all();
        return $rows;
    }

    public function create_array($rows){
        foreach($rows as $row){
            $i= $row['id'];
            $catgory[$i] = Categories::find()->select(['c.category','c.icon'])->from('categories c')->where("c.id = $i")->groupBy('c.category')->one();
        }

        $fun = new Functions();
        foreach($rows as $row){
            $data[] = array('category' => $catgory[$row['id']]['category'],
                            'icon' => $catgory[$row['id']]['icon'],
                            'title' => $row['title'],
                            'description' => $row['description'],
                            'budget' => $row['budget'],
                            'address' => $row['address'],
                            'date_diff' => $fun->diff_result($row['dt_add']),
                            'deadline' => $row['deadline']
                            );
        }
        
        return $data;
    }
    
}
