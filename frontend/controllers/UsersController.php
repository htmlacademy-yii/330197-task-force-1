<?php

namespace frontend\controllers;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use frontend\models\src\UsersModule;
use frontend\models\categories;

class UsersController extends Controller
{
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = true;
        return true;
    }
    
    public function actionIndex()
    {   
        $form_data = array();
        
        if (Yii::$app->request->getIsPost()) {
            $form_data = Yii::$app->request->post();
        }
    
        $category = Categories::find()->select(['category', 'id'])->from('categories')->all();
        $data['categories'] = (ArrayHelper::map($category, 'id', 'category'));

        $data['addition'] = ['free' => 'Сейчас свободен',
                            'online' => 'Сейчас онлайн',
                            'feedback' => 'Есть отзывы',
                            'favorite' => 'В избранном'
                        ];

        $user = new UsersModule('users');
        $data['executers'] = $user->getData($form_data);
        return $this->render('/site/users',$data);
    }

}
