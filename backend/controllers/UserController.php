<?php

namespace backend\controllers;

use yii\helpers\Url;
use dektrium\user\controllers\AdminController as BaseAdminController;

class UserController extends BaseAdminController
{
    public function actionJobInfo($id)
    {
        Url::remember('', 'actions-redirect');
        $user = $this->findModel($id);

        return $this->render('_job_info', [
            'user' => $user,
        ]);
    }
}
