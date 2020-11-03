<?php

namespace frontend\controllers;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use frontend\models\src\TasksSearch;
use frontend\models\categories;
use frontend\models\CategoriesFormNew;
use frontend\models\Tasks;

class TasksController extends Controller
{   
    public function actionIndex()
    {
        $task_form = new CategoriesFormNew();
        $form_data = array();
        
        if (Yii::$app->request->getIsPost()) {
            $form_data = Yii::$app->request->post();
            $task_form->load($form_data);
        }
    
        $category = Categories::find()->select(['category', 'id'])->from('categories')->all();
        $categories = (ArrayHelper::map($category, 'id', 'category'));

        $categoryTask = Categories::find()->select(['category', 'id','icon'])->from('categories')->all();
        $categoryTasks = (ArrayHelper::map($categoryTask, 'category','icon', 'id'));
        
        $period = [ 'all_time' => 'За всё время',
                    'day' => 'За день',
                    'week' => 'За неделю',
                    'month' => 'За месяц'];
        
        $search = new TasksSearch('task');
        $parsed_data = $search->parse_data($form_data['CategoriesFormNew']);
        $rows = $search->search($parsed_data);
        $tasks = $search->search($parsed_data);
        return $this->render('/site/tasks', ['categories' => $categories,
                                             'categoryTasks' => $categoryTasks,
                                             'period' => $period,
                                             'task_form' => $task_form,
                                             'tasks' => $tasks]);
    }

}
