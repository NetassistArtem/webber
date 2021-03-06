<?php

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'homeUrl'=> '/bills',
    'defaultRoute' => 'site/bills',



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
            'enableAutoLogin' => false,
            'authTimeout' => 60*15
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
            'messageConfig' => [
                'charset' => 'UTF-8',
            ],
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
                    'pattern' => 'logout',
                    'route' => 'site/logout',
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
                    'pattern' => 'invoices',
                    'route' => 'site/invoices',
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
                    'pattern' => 'settings/edit-main-settings',
                    'route' => 'settings/edit-main-settings',
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
                [
                    'pattern' => 'settings/edit-setting',
                    'route' => 'settings/edit-setting',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'settings/edit-logo',
                    'route' => 'settings/edit-logo',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'settings/delete-logo',
                    'route' => 'settings/delete-logo',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'settings/change-logo',
                    'route' => 'settings/change-logo',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'settings/delete-month-year-services',
                    'route' => 'settings/delete-month-year-services',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],

                [
                    'pattern' => 'services',
                    'route' => 'site/services',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'services/edit-service',
                    'route' => 'site/edit-service',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'services/delete-service',
                    'route' => 'site/delete-service',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],

                [
                    'pattern' => 'payers',
                    'route' => 'site/payers',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'payers/edit-payer',
                    'route' => 'site/edit-payer',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'payers/delete-payer',
                    'route' => 'site/delete-payer',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'payers/payer',
                    'route' => 'site/payer-view',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],

                [
                    'pattern' => 'bills',
                    'route' => 'site/bills',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'bills/edit-bill',
                    'route' => 'site/edit-bill',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'bills/delete-bill',
                    'route' => 'site/delete-bill',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'bills/bill-view',
                    'route' => 'site/bill-view',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'bills/bill-print',
                    'route' => 'site/bill-print',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'bills/bill-act-print',
                    'route' => 'site/bill-act-print',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'bills/add-bill-main',
                    'route' => 'site/add-bill-main',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'bills/add-bill-second',
                    'route' => 'site/add-bill-second',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'bills/edit-bill-main',
                    'route' => 'site/edit-bill-main',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'bills/act-view',
                    'route' => 'site/act-view',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'bills/act-edit',
                    'route' => 'site/act-edit',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'bills/act-print',
                    'route' => 'site/act-print',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'arhive',
                    'route' => 'site/arhive',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'arhive-return-unit',
                    'route' => 'site/arhive-return-unit',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'arhive-return-header',
                    'route' => 'site/arhive-return-footer-header',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'arhive-return-footer',
                    'route' => 'site/arhive-return-footer-header',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'arhive-return-service',
                    'route' => 'site/arhive-return-service',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'arhive-return-payer',
                    'route' => 'site/arhive-return-payer',
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
