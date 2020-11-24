<?php

namespace frontend\controllers;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use frontend\models\Categories;
use frontend\models\CategoriesFormNew;
use frontend\models\Tasks;
use frontend\functions;

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

        $task = new Tasks();
        $tasks = $task->filter($form_data['CategoriesFormNew']);

        return $this->render('/site/tasks', ['categories' => $categories,
                                             'categoryTasks' => $categoryTasks,
                                             'period' => $period,
                                             'task_form' => $task_form,
                                             'tasks' => $tasks]);
    }

}
