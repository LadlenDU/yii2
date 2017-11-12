<?php

namespace common\models\helpers;

use Yii;
use common\models\User;

/**
 * This is the model class for table "debtor_common_recalculate_monitor".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $total_debtors
 * @property integer $last_recounted_debtor_id
 * @property string $started_at
 * @property string $continued_at
 * @property string $finished_at
 *
 * @property User $user
 */
class DebtorCommonRecalculateMonitor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'debtor_common_recalculate_monitor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'total_debtors', 'last_recounted_debtor_id'], 'integer'],
            [['started_at', 'continued_at', 'finished_at'], 'safe'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'Пользователь, должники которого пересчитываются'),
            'total_debtors' => Yii::t('app', 'Кол-во должников на момент старта перерасчета'),
            'last_recounted_debtor_id' => Yii::t('app', 'ID последнего перерасчитанного должника'),
            'started_at' => Yii::t('app', 'Начало перерасчета (первая попытка)'),
            'continued_at' => Yii::t('app', 'Продолжение перерасчета (последнее после прерывания)'),
            'finished_at' => Yii::t('app', 'Завершение перерасчета (не нулевое значение обозначает конец перерасчета)'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id'])->inverseOf('debtorCommonRecalculateMonitors');
    }
}
