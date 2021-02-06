<?php

namespace frontend\controllers;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use frontend\models\Cities;
use frontend\models\SignupForm;
use frontend\models\Users;

class SignupController extends Controller
{
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = true;
        return true;
    }
    
    public function actionIndex()
    {   
        $form_model = new SignupForm();
        $form_data = array();
        $user = new Users();

        if (Yii::$app->request->getIsPost()) {
            $error = [];
            $form_data = Yii::$app->request->post();
            $form_model->load($form_data);

            $email_find = $user->find()->where(['=','email',$form_model->email])->one();
            if(!empty($email_find->id)){
               $error['email'] = "Адрес электронной почты $form_model->email уже используется"; 
            }
            if(strlen($form_model->password) < 8){
                $error['password'] = "Пароль должен быть не меньше 8 символов"; 
            }
            if(empty($form_model->city_id) or empty($form_model->username) or empty($form_model->email) or empty($form_model->password)){
                $error['field'] = "Все поля должны быть заполнены"; 
            }
            if(empty($error)){
                $user->fio = $form_model->username;
                $user->email = $form_model->email;
                $user->pass = password_hash($form_model->password,1);
                $user->city_id = $form_model->city_id;
                $user->role = 1;
                $user->save();
                Yii::$app->response->redirect(['index.php']);
            }
        }
        
        $city = Cities::find()->select(['city', 'id'])->all();
        $cities = (ArrayHelper::map($city, 'id', 'city'));

        return $this->render('/site/signup',['form_model' => $form_model,
                                            'cities' => $cities,
                                            'error' => $error]);
    }
}
