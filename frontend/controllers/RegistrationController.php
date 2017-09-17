<?php

namespace frontend\controllers;

#use Yii;
use dektrium\user\controllers\RegistrationController as BaseRegistrationController;
use yii\web\NotFoundHttpException;
use common\models\UserInfo;

class RegistrationController extends BaseRegistrationController
{
    public function behaviors()
    {
        $behaviour = parent::behaviors();
        $behaviour['access']['rules'][] = ['allow' => true, 'actions' => ['init'], 'roles' => ['@']];
        return $behaviour;
    }

    /** @inheritdoc */
    public function actionConfirm($id, $code)
    {
        $user = $this->finder->findUserById($id);

        if ($user === null || $this->module->enableConfirmation == false) {
            throw new NotFoundHttpException();
        }

        $event = $this->getUserEvent($user);

        $this->trigger(self::EVENT_BEFORE_CONFIRM, $event);

        $showRegistrationForm = $user->attemptConfirmation($code);

        $this->trigger(self::EVENT_AFTER_CONFIRM, $event);

        //$title = $showRegistrationForm ? \Yii::t('app', 'Регистрация: выбор варианта') : \Yii::t('user', 'Account confirmation');

        return $this->render('@frontend/views/registration/go_to_init', [
            'title' => \Yii::t('user', 'Account confirmation'),
            'module' => $this->module,
            'need_registration_form' => $showRegistrationForm,
        ]);
    }

    public function actionInit()
    {
        //if ($complete = UserInfo::find()->select(['complete'])->where(['user_id' => $this->id])->one()) {
        if ($model = UserInfo::find()->where(['user_id' => \Yii::$app->user->identity->getId()])->one()) {
            if ($model->attributes['registration_type_id']) {
                return $this->redirect(['/office/my-organization']);
            }
        } else {
            $model = \Yii::createObject(UserInfo::className());
            $model->link('user', \Yii::$app->user->identity);
        }

        $model->scenario = UserInfo::SCENARIO_SELECT_REGISTRATION_TYPE;

        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            $model->complete = 1;
            if ($model->save()) {
                return $this->redirect(['/office/my-organization']);
            }
        }

        return $this->render('@frontend/views/registration/init', [
            'title' => \Yii::t('app', 'Регистрация: выбор варианта'),
            'module' => $this->module,
            'model' => $model,
        ]);
    }
}
