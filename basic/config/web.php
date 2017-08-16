<?php

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'homeUrl'=> '/invoice',
    'defaultRoute' => 'site/invoice',



    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '7rfd7ty65gf5gfd08jf346',
            'baseUrl' => '',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'normalizer' => [
                'class' => 'yii\web\UrlNormalizer',
                'collapseSlashes' => true,
            ],
            'rules' => [
                [
                    'pattern' => 'login',
                    'route' => 'site/login',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'error',
                    'route' => 'site/error',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'home',
                    'route' => 'site/index',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'invoice',
                    'route' => 'site/invoice',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'settings',
                    'route' => 'settings/index',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'settings/edit-unit',
                    'route' => 'settings/edit-unit',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'settings/delete-unit',
                    'route' => 'settings/delete-unit',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'settings/edit-header',
                    'route' => 'settings/edit-header',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'settings/delete-header',
                    'route' => 'settings/delete-header',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'settings/edit-footer',
                    'route' => 'settings/edit-footer',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'settings/delete-footer',
                    'route' => 'settings/delete-footer',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
            ],
        ],

    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;