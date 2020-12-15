<?php

namespace frontend\controllers;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use frontend\models\Categories;
use frontend\models\UsersForm;
use frontend\models\ExecutersCategory;
use frontend\models\Users;

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

        $user = new Users();
        $users = $user->search($form_data['UsersForm']);
        $users_addition = $user->getAddition($users);
        $users_rate = $user->getRates($users);
        $users_tasks = $user->getTaskCount($users);

        return $this->render('/site/users',['sortField' => $sortField,
                                            'categories' => $categories,
                                            'users' => $users,
                                            'users_addition' => $users_addition,
                                            'users_rate' => $users_rate,
                                            'users_tasks' => $users_tasks,
                                            'user_form' => $user_form,
                                        ]);
    }

}
