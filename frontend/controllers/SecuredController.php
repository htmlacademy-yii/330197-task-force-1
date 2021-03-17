<?php
namespace frontend\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;

/**
 * Site controller
 */
abstract class SecuredController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    
}
