<?php

namespace frontend\models\src;

use Yii;
use yii\base\Module;
use frontend\models\Tasks;
use frontend\models\Categories;
use frontend\functions;

class TasksModule extends Module{
	
	/*Выводим данные для представления*/
    public function getData($form_data = null){
        if($form_data['categories']){
            $categories = implode(",",$form_data['categories']);
        }
        if($form_data['no_executers']){
            $no_executers = true;
        }
        if($form_data['no_address']){
            $no_address = true;
        }
        if($form_data['period']){
            switch ($form_data['period']) {
                case 'day':
                    $period = date('Y-m-d',time()-86400);
                    break;
                case 'week':
                    $period = date('Y-m-d',time()-86400*7);
                    break;
                case 'month':
                    $period = date('Y-m-d',time()-86400*30);
                    break;
                default:
                    $period = false;
                    break;
            }
        }
        if($form_data['find']){
            $find = $form_data['find'];
        }

    	$task = new Tasks();
        $query = $task->find()->select(['t.title','t.description','t.budget','t.address','t.dt_add','t.deadline','t.idcategory as id'])->from(['tasks t'])->where("current_status = 'new'");
        //Подключаем переданные фильтры через форму
        if($categories){
            $query = $query->andWhere("t.idcategory in ($categories)");
        }
        if($no_executers){
            $query = $query->andWhere("t.id not in (select distinct idtask from responds)");
        }
        if($no_address){
            $query = $query->andWhere("t.latitude is null or t.longitude is null");
        }
        if($period){
            $query = $query->andWhere("date(dt_add) >= date('".$period."')");
        }
        if($find){
            $query = $query->andWhere("MATCH(title) AGAINST('*$find*' in boolean mode)");
        }

        $query = $query->orderBy(['t.dt_add' => SORT_DESC])->limit(5);
        $rows = $query->all();

        $categ = new Categories();

        foreach($rows as $row){
            $i= $row['id'];
            $catgory[$i] = $categ->find()->select(['c.category','c.icon'])->from('categories c')->where("c.id = $i")->groupBy('c.category')->one();
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