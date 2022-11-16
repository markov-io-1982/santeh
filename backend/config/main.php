<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    //'homeUrl' => '',
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'language' => 'ru',
    'sourceLanguage' => 'en',
    'modules' => [],
    'components' => [
        'i18n' => [
            'translations' => [
                'app' => [
                    //'class' => 'yii\i18n\DbMessageSource',
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
            'csrfParam' => '_csrf-backend',
            'baseUrl' => '/admin',

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
            'enableStrictParsing' => true,
            'rules' => [
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
            ],
        ],
        'view' => [
             'theme' => [
                 'pathMap' => [
                    '@app/views' => '@backend/views'
                 ],
             ],
        ],
    ],
    'as beforeRequest' => [ // действие которое выполняется до загрузки
        'class' => 'backend\components\CheckIfLoggedIn',
    ],
    'params' => $params,
];
