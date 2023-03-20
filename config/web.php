<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'jvGAHklnnTuzlZZAlHheaP2nD__P8Ahz',
            'parsers' => [
                'application/json' => \yii\web\JsonParser::class,
            ]
        ],
        'jwt' => [
            'class' => \sizeg\jwt\Jwt::class,
            'key' => 'SECRET-KEY',
            //typically a long random string
            'jwtValidationData' => \app\components\JwtValidationData::class,
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
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
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
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
                'diary/<id:\d+>' => 'site/diary',
                'dashboard/<page:\d+>' => 'site/dashboard',
                'login' => 'site/login',
                'logout' => 'site/logout',
                'POST register' => 'site/register',
                'POST auth/login' => 'auth/login',
                'POST post/<id:\d+>' => 'site/post',
                'GET editpost/<post:\d+>' => "site/editpost",
                'POST editpost/<post:\d+>' => "site/editpostupdate",
                'GET deletepost/<post:\d+>' => "site/editpostdelete",
                "error" => "site/error",
                ['class' => 'yii\rest\UrlRule', 'controller' => 'api/post'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'api/diary'],

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