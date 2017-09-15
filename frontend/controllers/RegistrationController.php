<?php

namespace frontend\controllers;

use dektrium\user\controllers\RegistrationController as BaseRegistrationController;
use yii\web\NotFoundHttpException;

class RegistrationController extends BaseRegistrationController
{
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

        $title = $showRegistrationForm ? \Yii::t('app', 'Регистрация: выбор варианта') : \Yii::t('user', 'Account confirmation');

        return $this->render('@frontend/views/registration/init', [
            'title' => $title,
            'module' => $this->module,
        ]);
    }
}
