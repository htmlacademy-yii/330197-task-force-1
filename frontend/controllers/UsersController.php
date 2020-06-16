<?php

namespace frontend\controllers;
use Yii;
use yii\web\Controller;
use frontend\models\src\UsersModule;

class UsersController extends Controller
{	
    public function actionIndex()
    {	
    	$user = new UsersModule('users');
    	$data['data'] = $user->getData();
        return $this->render('/site/users',$data);
    }

}
