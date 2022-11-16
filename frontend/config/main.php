<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    //'homeUrl' => '/demo/alex/vape',       //  !!! добавлено
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'homeUrl' => '',
    'bootstrap' => ['log'],
    'language' => 'ru',
    'sourceLanguage' => 'en',
    'charset' => 'utf-8',
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'i18n' => [
            'translations' => [
                'app' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'sourceLanguage' => 'en',
                    'fileMap' => [
                        'app' => 'app.php',
                        'app/error' => 'error.php',
                    ],
                ],
            ],
        ],
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'baseUrl' => '',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
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
            'enableStrictParsing' => true,
            'rules' => [
                'sitemap.xml' => 'sitemap/index',
                '<controller:(cart)>' => '<controller>/index',
                '<controller:(order)>' => '<controller>/index',
                '<action:(login|logout|about|contact)>' => 'site/<action>',
                '<action:(products)>/<category:[\w-]*>/<id:[\w-]*>' => 'shop/<action>',
                '<action:(products)>/<category:[\w-]*>' => 'shop/<action>',
                '<action:(products)>' => 'shop/<action>',
                '<action:(search)>' => 'shop/<action>',
                [
                    'pattern' => '',
                    'route' => 'site/index',
                    'suffix' => '',
                ],
                [
                    'pattern' => '<controller>/<action>',
                    'route' => '<controller>/<action>',
                    'suffix' => ''
                ],
                '<id:[\w-]*>' => 'site/page',

            ],
        ],
    ],
    'as beforeRequest' => [ // действие которое выполняется до загрузки
        'class' => 'backend\components\CheckIfLoggedIn',
    ],
    'params' => $params,
];
