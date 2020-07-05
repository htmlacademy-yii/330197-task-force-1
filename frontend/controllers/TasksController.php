<?php

namespace frontend\controllers;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use frontend\models\src\TasksModule;
use frontend\models\categories;

class TasksController extends Controller
{	
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return true;
    }

    public function actionIndex()
    {
    	$form_data = array();

	if (Yii::$app->request->getIsPost()) {
		$form_data = Yii::$app->request->post();
	}
	
        $category = new Categories();
        $cats = $category->find()->select(['category', 'id'])->from('categories')->all();
        $data['categories'] = (ArrayHelper::map($cats, 'id', 'category'));

        $data['addition'] = ['no_executers' => 'Без откликов',
	                    	'no_address' => 'Удаленная работа'];
        
        $data['period'] = ['day' => 'За день',
	                    'week' => 'За неделю',
	                    'month' => 'За месяц'];
        
    	$task = new TasksModule('task');
    	$data['data'] = $task->getData($form_data);
    	return $this->render('/site/tasks', $data);
    }
}