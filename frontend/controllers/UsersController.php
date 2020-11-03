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
        $sortField = (isset($_GET['s'])) ? $_GET['s'] : 'date';
        $form_data['UsersForm']['s'] = $sortField;

        if (Yii::$app->request->getIsPost()) {
            $form_data = Yii::$app->request->post();
            $user_form->load($form_data);
        }

        $category = Categories::find()->select(['category', 'id'])->from('categories')->all();
        $categories = (ArrayHelper::map($category, 'id', 'category'));

        $search = new UsersSearch('users');
        $parsed_data = $search->parse_data($form_data['UsersForm']);
        $users = $search->search($parsed_data);
        $users_addition = $search->getAddition($users);

        return $this->render('/site/users',['sortField' => $sortField,
                                            'categories' => $categories,
                                            'users' => $users,
                                            'users_addition' => $users_addition,
                                            'user_form' => $user_form]);
    }

}
