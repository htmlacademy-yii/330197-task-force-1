<?php

namespace frontend\controllers;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Response;
use yii\helpers\Json;
use yii\filters\AccessControl;
use frontend\models\Categories;
use frontend\models\Tasks;
use frontend\models\LoginForm;
use yii\web\NotFoundHttpException;
use yii\widgets\ActiveForm;

class LandingController extends Controller
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
                        'roles' => ['?','@']
                    ]
                ]
            ]
        ];
    }

    public function actionIndex()
    {   

        if (!Yii::$app->user->isGuest) {
            $this->layout = '/main';
            $isGuest = false;
        } else {
            $this->layout = '/main_landing';
            $isGuest = true;
        }

        $categoryTask = Categories::find()->select(['category', 'id','icon'])->all();
        $categoryTasks = (ArrayHelper::map($categoryTask, 'category','icon', 'id'));
        $task = new Tasks;
        $tasks = $task->filter(4);

        $this->view->params['loginForm'] = new LoginForm();

        if (Yii::$app->request->getIsPost()) {

            $this->view->params['loginForm']->load(Yii::$app->request->post());

            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($this->view->params['loginForm']);
            }

            if ($this->view->params['loginForm']->validate()) {
                $user = $this->view->params['loginForm']->getUser();
                Yii::$app->session->close();
                Yii::$app->user->login($user);

                $this->layout = '/main';
                return $this->render('/site/landing',[  'categoryTasks' => $categoryTasks,
                                                        'tasks' => $tasks,
                                                    ]);
            }
        }

        return $this->render('/site/landing',[  'categoryTasks' => $categoryTasks,
                                                'tasks' => $tasks,
                                                'isGuest' => $isGuest,
                                            ]);
    }
}
