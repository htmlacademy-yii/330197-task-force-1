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
use yii\web\Response;
use yii\helpers\Json;
use frontend\src\models\task;

class CreateController extends SecuredController
{   
    public function beforeAction($action) 
    { 
        if ($this->action->id == 'upload') {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $this->enableCsrfValidation = false;
        }

        return true;
    }

    public function actionIndex()
    {        
        $id = \Yii::$app->user->getId();
        $user_profile = Users::findOne($id);

        if($user_profile->role !== 1){
            throw new NotFoundHttpException("У Вас нет доступа к этой странице");
        }
        
        $form_model = new CreateForm();
        $task = new Tasks();

        if (Yii::$app->request->getIsPost()) {
            $form_model->load(Yii::$app->request->post());
            $task->attach_id = Yii::$app->session->get('attach_id');
        } else {
            $attach_id = uniqid();
            Yii::$app->session->set('attach_id', $attach_id);
        }

        if ($form_model->validate()) {
            $idcity = $form_model->idcity;
            $city = Cities::findone($idcity);
            $attach = $task->attach_id;
            $deadline = empty($form_model->deadline) ? date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s").'+1 month')) : date("Y-m-d H:i:s",strtotime($form_model->deadline));

            $task->idcustomer = $id;
            $task->title = $form_model->title;
            $task->description = $form_model->description;
            $task->idcategory = $form_model->idcategory;
            $task->budget = $form_model->budget;
            $task->dt_add = date("Y-m-d H:i:s");
            $task->deadline = $deadline;

            if($idcity){
                $task->idcity = $idcity;
                $task->latitude = $city->latitude;
                $task->longitude = $city->longitude;
            }
            $task->current_status = Task::STATUS_NEW;
            $task->save();

            $id_task = $task->getLastInsertID();
            StoredFiles::updateAll(['idtask' => $id_task], ['=','attach_id', $attach]);

            Yii::$app->response->redirect(['/tasks']);            
        }

        $category = Categories::find()->select(['category', 'id'])->all();
        $categories = (ArrayHelper::map($category, 'id', 'category'));

        return $this->render('/site/create', ['form_model' => $form_model,
                                              'categories' => $categories,
                                             ]);
    }

    public function actionUpload() {
        $cookies = Yii::$app->request->cookies;
        $file = UploadedFile::getInstanceByname('file');
        $attach_id = Yii::$app->session->get('attach_id');
        $filename = uniqid('upload') .'.'. $file->getExtension();

        $file->saveAs('@webroot/user_files/' . $filename);

        $stored_file = new StoredFiles();
        $stored_file->idtask = 1;
        $stored_file->file_path = $filename;
        $stored_file->attach_id = $attach_id;
        $stored_file->save();
    }
}
