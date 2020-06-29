<?php

namespace frontend\controllers;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use frontend\models\src\TasksModule;
use frontend\models\src\TasksFormModule;
use frontend\models\CategoriesFormNew;
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
    	// $this->enableCsrfValidation = false;

        // $task_form = new TasksFormModule('task-form');
        // $task_form = new TasksFormModule();
        $task_form = new CategoriesFormNew();
// var_dump($_POST); 
        if (Yii::$app->request->getIsGet()) {
           // $search = $task_form->search();
            $get = $task_form->load(Yii::$app->request->get());
            // var_dump($get); die('here');
            // if (!$task_form->validate()) {
            //     $errors = $user->getErrors();
            //     var_dump($errors);
            //     die;
            // }
            // var_dump($_POST);die('here');
        }

        $category = new Categories();
        $cats = $category->find()->select(['category', 'id'])->from('categories')->all();
        $data['categories'] = (ArrayHelper::map($cats, 'id', 'category'));
        $data['period'] = ['day' => 'За день',
	                    'week' => 'За неделю',
	                    'month' => 'За месяц'];
        
    	$task = new TasksModule('task');
    	$data['data'] = $task->getData();
    	$data['model'] = $task_form;
    	// var_dump($data['model']);die('here');
        return $this->render('/site/tasks', $data);
    }

}

// <?php

// namespace frontend\controllers;

// use Yii;
// use frontend\models\categories;
// use frontend\models\CategoriesSearch;
// use yii\web\Controller;
// use yii\web\NotFoundHttpException;
// use yii\filters\VerbFilter;

// /**
//  * TasksController implements the CRUD actions for categories model.
//  */
// class TasksController extends Controller
// {
//     /**
//      * {@inheritdoc}
//      */
//     public function behaviors()
//     {
//         return [
//             'verbs' => [
//                 'class' => VerbFilter::className(),
//                 'actions' => [
//                     'delete' => ['POST'],
//                 ],
//             ],
//         ];
//     }

//     /**
//      * Lists all categories models.
//      * @return mixed
//      */
//     public function actionIndex()
//     {
//         $searchModel = new CategoriesSearch();
//         $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

//         return $this->render('index', [
//             'searchModel' => $searchModel,
//             'dataProvider' => $dataProvider,
//         ]);
//     }

//     /**
//      * Displays a single categories model.
//      * @param integer $id
//      * @return mixed
//      * @throws NotFoundHttpException if the model cannot be found
//      */
//     public function actionView($id)
//     {
//         return $this->render('view', [
//             'model' => $this->findModel($id),
//         ]);
//     }

//     /**
//      * Creates a new categories model.
//      * If creation is successful, the browser will be redirected to the 'view' page.
//      * @return mixed
//      */
//     public function actionCreate()
//     {
//         $model = new categories();

//         if ($model->load(Yii::$app->request->post()) && $model->save()) {
//             return $this->redirect(['view', 'id' => $model->id]);
//         }

//         return $this->render('create', [
//             'model' => $model,
//         ]);
//     }

//     /**
//      * Updates an existing categories model.
//      * If update is successful, the browser will be redirected to the 'view' page.
//      * @param integer $id
//      * @return mixed
//      * @throws NotFoundHttpException if the model cannot be found
//      */
//     public function actionUpdate($id)
//     {
//         $model = $this->findModel($id);

//         if ($model->load(Yii::$app->request->post()) && $model->save()) {
//             return $this->redirect(['view', 'id' => $model->id]);
//         }

//         return $this->render('update', [
//             'model' => $model,
//         ]);
//     }

//     /*
//      * Deletes an existing categories model.
//      * If deletion is successful, the browser will be redirected to the 'index' page.
//      * @param integer $id
//      * @return mixed
//      * @throws NotFoundHttpException if the model cannot be found
     
//     public function actionDelete($id)
//     {
//         $this->findModel($id)->delete();

//         return $this->redirect(['index']);
//     }

//     /**
//      * Finds the categories model based on its primary key value.
//      * If the model is not found, a 404 HTTP exception will be thrown.
//      * @param integer $id
//      * @return categories the loaded model
//      * @throws NotFoundHttpException if the model cannot be found
//      */
//     protected function findModel($id)
//     {
//         if (($model = categories::findOne($id)) !== null) {
//             return $model;
//         }

//         throw new NotFoundHttpException('The requested page does not exist.');
//     }
// }

