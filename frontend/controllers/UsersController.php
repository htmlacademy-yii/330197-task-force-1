<?php

namespace frontend\controllers;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use frontend\models\Categories;
use frontend\models\UsersForm;
use frontend\models\ExecutersCategory;
use frontend\models\Users;
use frontend\models\Countries;
use frontend\models\Cities;
use frontend\models\Portfolio;
use yii\web\NotFoundHttpException;

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

        $category = Categories::find()->select(['category', 'id'])->all();
        $categories = (ArrayHelper::map($category, 'id', 'category'));

        $user = new Users();
        $users = $user->search($form_data['UsersForm']);
        $users_addition = $user->getAddition($users);

        foreach($users as $u){
            $users_rate['rate'][$u->id] = $user->getAvgRate($u->id);
            $users_rate['feedbacks'][$u->id] = $user->getCountFeedback($u->id);
            $users_tasks[$u->id] = $user->getExecuterTaskCount($u->id);
        }

        return $this->render('/site/users',['sortField' => $sortField,
                                            'categories' => $categories,
                                            'users' => $users,
                                            'users_addition' => $users_addition,
                                            'users_rate' => $users_rate,
                                            'users_tasks' => $users_tasks,
                                            'user_form' => $user_form,
                                        ]);
    }

    public function actionView($id)
    {
        $user = Users::findOne($id);
        if (!$user or $user->role !==2) {
            throw new NotFoundHttpException("Исполнитель с ID $id не найден");
        }
        $category = Categories::find()->select(['category', 'id'])->all();
        $categories = (ArrayHelper::map($category, 'id', 'category'));

        $user_rate = $user->getAvgRate($id);
        $user_feedbacks = $user->getFeedbackFullInfo($id);
        $user_tasks = $user->getExecuterTaskCount($id);
        $user_city = Cities::findOne($user->city_id);
        $user_country = Countries::findOne($user_city->country_id);
        $user_categories = $user->getArrayCaterories($id);
        $user_portfolio = $user->getArrayPortfolio($id);

        return $this->render('/site/user', ['user' => $user,
                                            'categories' => $categories,
                                            'user_rate' => $user_rate,
                                            'user_tasks' => $user_tasks,
                                            'user_city' => $user_city,
                                            'user_country' => $user_country,
                                            'user_categories' => $user_categories,
                                            'user_portfolio' => $user_portfolio,
                                            'user_feedbacks' => $user_feedbacks,
                                        ]);
    }

}
