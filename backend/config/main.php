<?php

use common\models\Word;

$object = new Word();

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'name' => 'English',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    //'on beforeRequest' => function () {
    //    Yii::$app->params['count20day'] = "100";
    //},
    'on beforeRequest' => [$object, 'countRequestPage'],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'wordrests'  => 'word/index',
                'wordrests/add'  => 'word/index',
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'wordrest',
                    'extraPatterns' => [
                        'GET search' => 'search', 
                        'POST learn' => 'learn',
                        'POST link' => 'link',
                    ],
                    'prefix' => 'api', //api будет доступен по url, начинающимся с /api/products
                ]
            ],
        ],        
    ],
    'params' => $params,
];
