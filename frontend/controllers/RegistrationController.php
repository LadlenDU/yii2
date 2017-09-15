<?php

namespace frontend\controllers;

use Yii;
use dektrium\user\controllers\RegistrationController as BaseRegistrationController;
use yii\web\NotFoundHttpException;

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
        return $this->render('@frontend/views/registration/init', [
            'title' => \Yii::t('app', 'Регистрация: выбор варианта'),
            'module' => $this->module,
        ]);
    }
}
