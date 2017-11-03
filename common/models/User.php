<?php

namespace common\models;

use common\models\stat\StatisticPrint;
use dektrium\user\models\User as BaseUser;
use dektrium\user\models\Token;
use common\models\UserInfo;
use common\events\UserBalanceEvent;

/**
 * @property UserInfo[] $userInfos
 */
class User extends BaseUser
{
    //const DECREASE_BALANCE = 'decreaseBalance';

    //TODO: CRUD - костыль - исправить
    public function getIsAdmin()
    {
        if (YII_ENV == 'dev') {
            return true;
        }
        return parent::getIsAdmin();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserInfo()
    {
        //TODO: подумать что делать если userInfo не существует
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

    public function decreaseBalance($amount, $operation)
    {
        if ($this->userInfo) {
            $event = new UserBalanceEvent;
            $event->amountToChange = $amount;
            $event->oldBalance = $this->userInfo->balance;

            $this->userInfo->balance -= $amount;
            //TODO: решить что с этим делать
            /*if ($this->userInfo->balance < 0) {
                $this->userInfo->balance = 0;
            }*/

            //$this->trigger(self::DECREASE_BALANCE, $event);
        }
    }

    public function printOperationStart()
    {
        //TODO: 500 вынести в БД или в настройки
        StatisticPrint::decreaseBalance(500, $this->userInfo->balance, $this->userInfo->primary_company);
        $this->decreaseBalance(500, 'print');
        $this->userInfo->save();
    }

    public function canPrint()
    {
        //TODO: 500 вынести в БД или в настройки
        return $this->userInfo->balance >= 500;
    }

    /*public function registrationInfo()
    {
        \Yii::$app->session->setFlash('info', \Yii::t('app', 'Пожалуйста, выберите ваш тип регистрации для продолжения.'));
    }*/
}
