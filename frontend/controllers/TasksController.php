<?php

namespace frontend\controllers;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use frontend\models\Categories;
use frontend\models\CategoriesFormNew;
use frontend\models\Tasks;
use frontend\models\Users;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

class TasksController extends SecuredController
{   
    public function actionIndex()
    {
        $task_form = new CategoriesFormNew();
        $form_data = array();
        
        if (Yii::$app->request->getIsPost()) {
            $form_data = Yii::$app->request->post();
            $task_form->load($form_data);
        }

        $category = Categories::find()->select(['category', 'id'])->all();
        $categories = (ArrayHelper::map($category, 'id', 'category'));

        $categoryTask = Categories::find()->select(['category', 'id','icon'])->all();
        $categoryTasks = (ArrayHelper::map($categoryTask, 'category','icon', 'id'));
        
        $period = [ 'all_time' => 'За всё время',
                    'day' => 'За день',
                    'week' => 'За неделю',
                    'month' => 'За месяц'];

        $task = new Tasks();
        $parsed_data = $task->parse_data($form_data['CategoriesFormNew']);
        $tasks = $task->filter(5,$parsed_data);

        return $this->render('/site/tasks', ['categories' => $categories,
                                             'categoryTasks' => $categoryTasks,
                                             'period' => $period,
                                             'task_form' => $task_form,
                                             'tasks' => $tasks]);
    }

    public function actionView($id)
    {
        $task = Tasks::findOne($id);
        if (!$task) {
            throw new NotFoundHttpException("Задача с ID $id не найдена");
        }
        $category = Categories::findOne($task->idcategory);

        $customer = Users::findOne($task->idcustomer);
        $users = new Users();
        $customer_tasks_count = $users->getCustomerTaskCount();

        $executers = $task->executerResponds;
        $files = $task->storedFiles;

        foreach($executers as $value){
            $user = Users::findOne($value->id_user);
            $executer_rate[$value->id_user] = $user->getAvgRate();
            $executer_info[$value->id_user] = $user;
        }

        return $this->render('/site/view', ['task' => $task,
                                            'category' => $category,
                                            'customer' => $customer,
                                            'customer_tasks_count' => $customer_tasks_count,
                                            'executers' => $executers,
                                            'executer_rate' => $executer_rate,
                                            'executer_info' => $executer_info,
                                            'files' => $files
                                        ]);
    }
}
