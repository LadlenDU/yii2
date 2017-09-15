<?php

namespace frontend\controllers;

class ManagerController extends \yii\web\Controller
{
    public $layout = 'manager';

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionInfo()
    {
        echo 'UUUUU+++++++++++++++++';
    }
}
