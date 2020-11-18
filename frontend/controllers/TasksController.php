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

        $parsed_data = $this->parse_data($form_data['CategoriesFormNew']);
        $rows = $this->search($parsed_data);
        $tasks = $this->search($parsed_data);
        return $this->render('/site/tasks', ['categories' => $categories,
                                             'categoryTasks' => $categoryTasks,
                                             'period' => $period,
                                             'task_form' => $task_form,
                                             'tasks' => $tasks]);
    }

    public function parse_data($form_data){

        if($form_data['category']){
            $form_data['category'] = implode(",",$form_data['category']);
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
        if($form_data['search']){
            $form_data['search'] = $form_data['search'];
        }

        return $form_data;
    }

    public function search($form_data = null){
        $query = Tasks::find()->select(['t.title','t.description','t.budget','t.address','t.dt_add','t.deadline','t.idcategory as id'])->from(['tasks t'])->where("current_status = 'new'");
        //Подключаем переданные фильтры через форму
        if($form_data['category']){
            $query = $query->andWhere("t.idcategory in (".$form_data['category'].")");
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
        if($form_data['search']){
            $query = $query->andWhere("MATCH(title) AGAINST('*".$form_data['search']."*' in boolean mode)");
        }

        $query = $query->orderBy(['t.dt_add' => SORT_DESC])->limit(5);
        $rows = $query->all();
        return $rows;
    }

}
