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
use frontend\models\FeedbackAboutExecuter;
use yii\web\NotFoundHttpException;

class UsersController extends SecuredController
{
    public function actionIndex($s = null)
    {   
        $user_form = new UsersForm;
        $form_data = [];
        $sortField = isset($s) ? $s : 'date';
        $form_data['UsersForm']['s'] = $sortField;

        if (Yii::$app->request->getIsPost()) {
            $form_data = Yii::$app->request->post();
            $user_form->load($form_data);
        }

        $category = Categories::find()->select(['category', 'id'])->all();
        $categories = (ArrayHelper::map($category, 'id', 'category'));

        $user = new Users;
        $users = $user->search($form_data['UsersForm']);


        foreach($users as $u){
            $executer = Users::findOne($u->id);
            $users_rate['rate'][$u->id] = $executer->getAvgRate();
            $users_rate['feedbacks'][$u->id] = $executer->getExecutersFeedbackCount();
            $users_tasks[$u->id] = $executer->getExecuterTaskCount();
            $users_categories[$u->id] = $executer->getExecutersCaterories();
        }

        return $this->render('/site/users',['sortField' => $sortField,
                                            'categories' => $categories,
                                            'users' => $users,
                                            'users_categories' => $users_categories,
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

        $user_rate = $user->getAvgRate();
        $user_feedbacks = $user->getFeedbackFullInfo();
        $user_tasks = $user->getExecuterTaskCount();
        $user_city = Cities::findOne($user->city_id);
        $user_country = Countries::findOne($user_city->country_id);
        $user_categories = $user->getExecutersCaterories();
        $user_portfolio = $user->getPortfolio($id);

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

    public function actionLogout() {
        Yii::$app->user->logout();
        return $this->goHome();
    }

}
