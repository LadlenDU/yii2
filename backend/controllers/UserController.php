<?php

namespace backend\controllers;

use common\models\UserInfo;
use yii\helpers\Url;
use dektrium\user\controllers\AdminController as BaseAdminController;

class UserController extends BaseAdminController
{
    public function actionUpdateJobInfo($id)
    {
        //TODO: что это?
        Url::remember('', 'actions-redirect');
        //$user = $this->findModel($id);
        //$user = \Yii::$app->user->identity;
        //$userInfo = $user->userInfo;
        $user = $this->findModel($id);
        $userInfo = $user->userInfo;

        if (!$userInfo) {
            $userInfo = \Yii::createObject(UserInfo::className());
            $userInfo->link('user', $user);
        }

        $this->performAjaxValidation($userInfo);

        if ($userInfo->load(\Yii::$app->request->post()) && $userInfo->save()) {
            \Yii::$app->getSession()->setFlash('success', \Yii::t('app', 'Информация успешно обновлена'));
            return $this->refresh();
        }

        return $this->render('_job_info', [
            'user' => $user,
            'userInfo' => $userInfo,
        ]);
    }
}
