<?php

namespace frontend\controllers;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use frontend\models\src\UsersSearch;
use frontend\models\categories;
use frontend\models\UsersForm;

class UsersController extends Controller
{
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = true;
        return true;
    }
    
    public function actionIndex()
    {   
        $user_form = new UsersForm();
        $form_data = array();
        $data['sort'] = (isset($_GET['s'])) ? $_GET['s'] : 'date';
        $form_data['UsersForm']['s'] = $data['sort'];

        if (Yii::$app->request->getIsPost()) {
            $form_data = Yii::$app->request->post();
            $user_form->load($form_data);
        }

        $category = Categories::find()->select(['category', 'id'])->from('categories')->all();
        $data['categories'] = (ArrayHelper::map($category, 'id', 'category'));

        $data['free'] = ['free' => 'Сейчас свободен'];
        $data['online'] = ['online' => 'Сейчас онлайн'];
        $data['feedback'] = ['feedback' => 'Есть отзывы'];
        $data['favorite'] = ['favorite' => 'В избранном'];

        $search = new UsersSearch('users');
        $parsed_data = $search->parse_data($form_data['UsersForm']);
        $data['users'] = $search->search($parsed_data);
        $data['users_addition'] = $search->getAddition($data['users']);

        $data['model'] = $user_form;
        return $this->render('/site/users',$data);
    }

}
