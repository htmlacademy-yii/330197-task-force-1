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
    'modules' => [
        'notifications' => [
            'class' => 'webzop\notifications\Module',
            'channels' => [
                'screen' => [
                    'class' => 'webzop\notifications\channels\ScreenChannel',
                ],
                'email' => [
                    'class' => 'webzop\notifications\channels\EmailChannel',
                    'message' => [
                        'from' => 'mailtest12330@gmail.com'
                    ],
                ],
                'web' => [
                    'class' => 'webzop\notifications\channels\WebChannel',
                    'enable' => true,                                       // OPTIONAL (default: true) enable/disable web channel
                    // 'config' => [
                    //     'serviceWorkerFilepath' => '/service-worker.js',    // OPTIONAL (default: /service-worker.js) is the service worker filename
                    //     'serviceWorkerScope' => '/app',                     // OPTIONAL (default: './' the service worker path) the scope of the service worker: https://developers.google.com/web/ilt/pwa/introduction-to-service-worker#registration_and_scope
                    //     'serviceWorkerUrl' => 'url-to-serviceworker',       // OPTIONAL (default: Url::to(['/notifications/web-push-notification/service-worker']))
                    //     'subscribeUrl' => 'url-to-subscribe-handler',       // OPTIONAL (default: Url::to(['/notifications/web-push-notification/subscribe']))
                    //     'unsubscribeUrl' => 'url-to-unsubscribe-handler',   // OPTIONAL (default: Url::to(['/notifications/web-push-notification/unsubscribe']))
                    //     'subscribeLabel' => 'subscribe button label',       // OPTIONAL (default: 'Subscribe')
                    //     'unsubscribeLabel' => 'subscribe button label',     // OPTIONAL (default: 'Unsubscribe')
                    // ],
                    'auth' => [
                        'VAPID' => [
                            'subject' => 'mailto:mailtest12330@gmail.com',  // can be a mailto: or your website address
                            'publicKey' => './public_key.txt',              // (recommended) uncompressed public key P-256 encoded in Base64-URL
                            'privateKey' => './private_key.txt',            // (recommended) in fact the secret multiplier of the private key encoded in Base64-URL
                            'pemFile' => './private_key.pem',               // if you have a PEM file and can link to it on your filesystem
                            // 'pem' => 'pemFileContent',                      // if you have a PEM file and want to hardcode its content
                            'reuseVAPIDHeaders' => true                     // OPTIONAL (default: true) you can reuse the same JWT token them for the same flush session to boost performance using
                        ],
                    ],
                ],
            ],
        ],
    ],
];
