<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'formatter' => [
            'nullDisplay' => '-',
        ],
        /*'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],*/
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
            'rules' => [
                '/office/my-organization/<action:[\w-]+>' => 'office/company/<action>',
                '/office/my-organization' => 'office/default/my-organization',

                '<module:\w+>/<controller:\w+>/<action:[\w-]+>/<id:(.*?)>' => '<module>/<controller>/<action>/<id>',
                '<module:\w+>/<controller:\w+>/<action:[\w-]+>' => '<module>/<controller>/<action>',
                //'<module:\w+>/<action:[\w-]+>/<id:(.*?)>' => '<module>/default/<action>/<id>',
                //'<module:\w+>/<action:[\w-]+>' => '<module>/default/<action>',

                '/office/user-file' => 'office/default/user-file',
                'pages/<page:[\w-]+>' => 'pages/default/index',
            ],
        ],
        /*'view' => [
            'theme' => [
                'pathMap' => [
                    '@dektrium/user/views' => '@frontend/views/user'
                ],
            ],
        ],*/
    ],
    'modules' => [
        'user' => [
            // following line will restrict access to admin controller from frontend application
            'as frontend' => 'dektrium\user\filters\FrontendFilter',
            'controllerMap' => [
                'registration' => 'frontend\controllers\RegistrationController',
                #'profile' => 'frontend\controllers\ProfileController',
                'settings' => 'frontend\controllers\SettingsController',
            ],
            'modelMap' => [
                'User' => 'frontend\models\User',
            ],
        ],
        'office' => [
            'class' => 'frontend\modules\office\Module',
        ],
        'dynagrid' => [
            'class' => '\kartik\dynagrid\Module',
            // other settings (refer documentation)
        ],
        'gridview' => [
            'class' => '\kartik\grid\Module',
            // other module settings
        ],
    ],

    'params' => $params,
];
