<?php

namespace frontend\models;

use dektrium\user\models\User as BaseUser;
use dektrium\user\models\Token;
use common\models\UserInfo;

/**
 * @property UserInfo[] $userInfos
 */
class User extends BaseUser
{
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserInfo()
    {
        return $this->hasOne(UserInfo::className(), ['user_id' => 'id'])->inverseOf('user');
    }

    public function attemptConfirmation($code)
    {
        $token = $this->finder->findTokenByParams($this->id, $code, Token::TYPE_CONFIRMATION);

        $message = false;
        $showRegistrationForm = false;
        $success = false;

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
            $message = \Yii::t('user', 'The confirmation link is invalid or expired. Please try requesting a new one.');
        }

        if ($message) {
            \Yii::$app->session->setFlash($success ? 'success' : 'danger', $message);
        }

        /*if ($showRegistrationForm) {
            $this->registrationInfo();
        }*/

        return $showRegistrationForm;
    }

    public function ifHasRequiredInfo()
    {
        //$this->userInfo->
    }

    /*public function registrationInfo()
    {
        \Yii::$app->session->setFlash('info', \Yii::t('app', 'Пожалуйста, выберите ваш тип регистрации для продолжения.'));
    }*/
}
