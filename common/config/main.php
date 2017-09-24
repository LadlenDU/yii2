<?php

use yii\filters\AccessControl;

return [
    'id' => 'software-package-upravdolg',
    'name' => 'Программный комплекс «УПРАВДОЛГ»',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
       /* 'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],*/
    ],
    'modules' => [
        'pages' => [
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
                                'roles' => ['@'],
                            ],
                        ],
                    ],
                ],
                'export' => 'phpnt\exportFile\controllers\ExportController',
            ],
            'pathToImages' => '@webroot/images',
            'urlToImages' => '@web/images',
            'pathToFiles' => '@webroot/files',
            'urlToFiles' => '@web/files',
            'uploadImage' => true,
            'uploadFile' => true,
            'addImage' => true,
            'addFile' => true,
        ],
        'rbac' => [
            'class' => 'dektrium\rbac\RbacWebModule',
            'admins' => ['Ladlen'],
        ],
        'treemanager' =>  [
            'class' => '\kartik\tree\Module',
            // other module settings, refer detailed documentation
        ],
        'user' => [
            'class' => 'dektrium\user\Module',
        ],
    ],
    'language' => 'ru-RU',
    //'sourceLanguage' => 'ru-RU',
    //'sourceLanguage' => 'en-US',

];
