<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language' => 'ru-RU',
    'bootstrap' => [
        'queue', // The component registers its own console commands
    ],
    'components' => [

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
                '//' => '/',
                'tasks/view/<id:\d+>' => 'tasks/view',
                'users/view/<id:\d+>' => 'users/view',
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],

        'queue' => [
            'class' => \yii\queue\sync\Queue::class,
            'handle' => true, // Флаг необходимости выполнять поставленные в очередь задания
            'as log' => \yii\queue\LogBehavior::class,
            // Other driver options
        ],
    ],
];
