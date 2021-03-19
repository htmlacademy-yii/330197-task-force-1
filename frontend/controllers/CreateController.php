<?php

namespace frontend\controllers;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use frontend\models\Categories;
use frontend\models\CreateForm;
use frontend\models\Tasks;
use frontend\models\Users;
use frontend\models\Cities;
use frontend\models\StoredFiles;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class CreateController extends SecuredController
{   

    public function beforeAction($action) 
    { 
        $this->enableCsrfValidation = false; 
        return parent::beforeAction($action); 
    }

    public function actionIndex()
    {        
        $id = \Yii::$app->user->getId();
        $user_profile = Users::findOne($id);

        if($user_profile->role !== 1){
            $errors['role'] = 'У Вас нет доступа к этой странице';            
            return $this->render('/site/error',['errors' => $errors]);
        }
        
        $form_model = new CreateForm();
        $task = new Tasks();
        $stored_file = new StoredFiles();

        if (Yii::$app->request->getIsPost()) {
            $form_model->load(Yii::$app->request->post());
            $form_model->file = UploadedFile::getInstance($form_model, 'file');
        }

        // $filename = uniqid('upload');
        // Yii::$app->session->set('filename', $filename);


        if ($form_model->file) {
            $filename = uniqid('upload') . '.' . $form_model->file->getExtension();           
            $form_model->file->saveAs('@webroot/user_files/' . $filename);
        }

        // if($form_model->file){
        //     $filename = uniqid('upload') . '.' . $form_model->file->getExtension();
        //     Yii::$app->session->set("filename", $filename);
        // }

        if ($form_model->validate()) {            
            $city = Cities::findone($form_model->idcity);

            $task->idcustomer = $id;
            $task->title = $form_model->title;
            $task->description = $form_model->description;
            $task->idcategory = $form_model->idcategory;
            $task->budget = $form_model->budget;
            $task->dt_add = date("Y-m-d H:i:s");
            $task->deadline = date("Y-m-d H:i:s",strtotime($form_model->deadline));
            $task->idcity = $form_model->idcity;
            $task->latitude = $city->latitude;
            $task->longitude = $city->longitude;
            $task->current_status = 'new';
            $task->save();

            $id_task = $task->getLastInsertID();
            if($filename){
                $stored_file->idtask = $id_task;
                $stored_file->file_path = $filename;
                $stored_file->save();
            }
            Yii::$app->response->redirect(['/tasks']);            
        }

        $category = Categories::find()->select(['category', 'id'])->all();
        $categories = (ArrayHelper::map($category, 'id', 'category'));

        return $this->render('/site/create', ['form_model' => $form_model,
                                              'categories' => $categories,
                                             ]);
    }

    public function actionUpload() {

        $file = UploadedFile::getInstance($form_model, 'file');
        $filename = Yii::$app->session->get('filename');

        $file->saveAs('@webroot/user_files/' . $filename .'.'. $file->getExtension());
        
    }
}
