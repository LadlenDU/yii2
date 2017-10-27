<?php

namespace frontend\controllers;

use dektrium\user\controllers\SettingsController as BaseSettingsController;
use yii\filters\AccessControl;

class SettingsController extends BaseSettingsController
{
    //@app/views/layouts/mainLayout
    public $layout = '@frontend/modules/office/views/layouts/main';

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
}
