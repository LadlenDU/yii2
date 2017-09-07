<?php

//use yii\filters\AccessControl;

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        /*'pages' => [
            'class' => 'bupy7\pages\Module',
            'controllerMap' => [
                'manager' => [
                    'class' => 'bupy7\pages\controllers\ManagerController',
                    'as access' => [
                        'class' => AccessControl::className(),
                        'rules' => [
                            [
                                'allow' => true,
                                //'roles' => ['admin'],
                                'roles' => ['*'],
                            ],
                        ],
                    ],
                ],
            ],
            'pathToImages' => '@webroot/images',
            'urlToImages' => '@web/images',
            'pathToFiles' => '@webroot/files',
            'urlToFiles' => '@web/files',
            'uploadImage' => true,
            'uploadFile' => true,
            'addImage' => true,
            'addFile' => true,
        ],*/
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
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
            ],
        ],
        /*'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@vendor/dmstr/yii2-adminlte-asset/example-views/yiisoft/yii2-app'
                ],
            ],
        ],*/
        /*'assetManager' => [
            'bundles' => [
                'dmstr\web\AdminLteAsset' => [
                    'skin' => 'skin-black',
                ],
            ],
        ],*/
    ],
    'params' => $params,
];
