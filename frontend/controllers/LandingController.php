<?php

namespace frontend\controllers;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\filters\AccessControl;
use frontend\models\Categories;
use frontend\models\Tasks;
use frontend\models\LoginForm;
use yii\web\NotFoundHttpException;

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
        $categoryTask = Categories::find()->select(['category', 'id','icon'])->all();
        $categoryTasks = (ArrayHelper::map($categoryTask, 'category','icon', 'id'));
        $task = new Tasks();
        $tasks = $task->filter(4);

        $loginForm = new LoginForm();

        if (Yii::$app->request->getIsPost()) {            
            $loginForm->load(Yii::$app->request->post());

            if ($loginForm->validate()) {
                $user = $loginForm->getUser();
                \Yii::$app->user->login($user);

                $this->layout = '/main';
                return $this->render('/site/landing',[  'categoryTasks' => $categoryTasks,
                                                        'tasks' => $tasks,
                                                    ]);
            } else {
                $error = "Неправильный email или пароль";
                $this->layout = '/main_landing';
                return $this->render('/site/error',['error' => $error ]);
            }
        }

        $this->layout = '/main_landing';
        return $this->render('/site/landing',[  'categoryTasks' => $categoryTasks,
                                                'tasks' => $tasks,
                                            ]);
    }
}
