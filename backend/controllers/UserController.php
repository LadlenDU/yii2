<?php

namespace backend\controllers;

use common\models\stat\StatisticPrint;
use common\models\stat\StatisticPrintSearch;
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
        $userInfo = $this->getUserInfo($user);

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

    public function actionStatBalance($id)
    {
        $searchModel = null;
        $dataProvider = null;

        Url::remember('', 'actions-redirect');
        $user = $this->findModel($id);
        $userInfo = $this->getUserInfo($user);
        //TODO: что-то здесь не так (привязка не правильная)
        if ($userInfo->primary_company) {
            //$searchModel = StatisticPrintSearch::find()->where(['company_id' => $userInfo->primary_company]);
            $searchModel = new StatisticPrintSearch();
            $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        }

        return $this->render('_stat_balance', [
            'user' => $user,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function getUserInfo($user)
    {
        $userInfo = null;

        if ($user) {
            $userInfo = $user->userInfo;

            if (!$userInfo) {
                $userInfo = \Yii::createObject(UserInfo::className());
                $userInfo->link('user', $user);
            }
        }

        return $userInfo;
    }

}
