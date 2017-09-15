<?php

namespace frontend\models;

use dektrium\user\models\User as BaseUser;
use dektrium\user\models\Token;
use common\models\UserInfo;

class User extends BaseUser
{
    public function attemptConfirmation($code)
    {
        $token = $this->finder->findTokenByParams($this->id, $code, Token::TYPE_CONFIRMATION);

        $message = false;
        $showRegistrationForm = false;

        if ($token instanceof Token && !$token->isExpired) {
            $token->delete();
            if (($success = $this->confirm())) {
                \Yii::$app->user->login($this, $this->module->rememberFor);
                #$message = \Yii::t('user', 'Thank you, registration is now complete.');
                $message = \Yii::t('app', 'Спасибо, вы успешно подтвердили ваш email адрес.');
                $showRegistrationForm = true;
            } else {
                $message = \Yii::t('user', 'Something went wrong and your account has not been confirmed.');
            }
        } else {
            $success = false;
            if ($complete = UserInfo::find()->select(['complete'])->where(['user_id' => $this->id])->one()) {
                $message = \Yii::t('user', 'The confirmation link is invalid or expired. Please try requesting a new one.');
            } else {
                $showRegistrationForm = true;
            }

        }

        if ($message) {
            \Yii::$app->session->setFlash($success ? 'success' : 'danger', $message);
        }

        if ($showRegistrationForm) {
            $this->registrationInfo();
        }

        return $showRegistrationForm;
    }

    public function registrationInfo()
    {
        \Yii::$app->session->setFlash('info', \Yii::t('app', 'Пожалуйста, заполните форму для завершения регистрации.'));
    }
}
