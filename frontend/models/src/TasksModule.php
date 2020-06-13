<?php

namespace frontend\models\src;

use Yii;
use yii\base\Module;
use frontend\models\Tasks;
use frontend\models\Categories;
use frontend\functions;

class TasksModule extends Module{
	
	/*Выводим данные для представления*/
    public function getData(){
    	$task = new Tasks();
        $query = $task->find()->select(['t.title','t.description','t.budget','t.address','t.dt_add','t.deadline','t.idcategory as id'])->from(['tasks t'])->where("current_status = 'new'")->orderBy(['t.dt_add' => SORT_DESC])->limit(10);
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