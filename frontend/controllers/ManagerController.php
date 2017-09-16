<?php

namespace frontend\controllers;

class ManagerController extends \yii\web\Controller
{
    public $layout = 'manager/main';

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionInfo()
    {
        return $this->render('info');
    }
}
