<?php

namespace frontend\controllers;
use Yii;
use yii\web\Controller;
use frontend\models\src\TasksModule;

class TasksController extends Controller
{	
    public function actionIndex()
    {	
    	$task = new TasksModule('task');
    	$data['data'] = $task->getData();
        return $this->render('..\site\tasks',$data);
    }

}
