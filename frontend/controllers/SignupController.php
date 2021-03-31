<?php

namespace frontend\controllers;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\filters\AccessControl;
use frontend\models\Cities;
use frontend\models\SignupForm;
use frontend\models\Users;
use frontend\src\models\task;

class SignupController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['?']
                    ]
                ]
            ]
        ];
    }

    public function actionIndex()
    {   
        $form_model = new SignupForm();
        $form_data = array();
        $user = new Users();

        if (Yii::$app->request->getIsPost()) {
            $form_data = Yii::$app->request->post();
            $form_model->load($form_data);
            if ($form_model->validate()) {
                $user->fio = $form_model->fio;
                $user->email = $form_model->email;
                $user->pass = password_hash($form_model->password,1);
                $user->city_id = $form_model->city_id;
                $user->role = $form_model->role;
                $user->save();
                Yii::$app->response->redirect(['index.php']);
            } else {
                $errors = $form_model->getErrors();
                return $this->render('/site/error',['errors' => $errors]);
            }
        }
        
        $city = Cities::find()->select(['city', 'id'])->all();
        $cities = (ArrayHelper::map($city, 'id', 'city'));

        $task = new Task;
        $role = $task->role_map;

        return $this->render('/site/signup',['form_model' => $form_model,
                                            'cities' => $cities,
                                            'role' => $role,]);
    }
}
