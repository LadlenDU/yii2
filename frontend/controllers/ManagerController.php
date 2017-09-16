<?php

namespace frontend\controllers;

use yii\filters\AccessControl;

class ManagerController extends \yii\web\Controller
{
    public $layout = 'manager/main';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionInfo()
    {
        return $this->render('info');
    }
}
