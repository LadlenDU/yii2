<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "debtor_status".
 *
 * @property integer $id
 * @property string $status
 * @property string $submitted_to_court_start
 * @property string $adjudicated_result
 * @property string $adjudicated_decision
 * @property string $application_withdrawn_reason
 *
 * @property Debtor[] $debtors
 * @property DebtorStatusFiles[] $debtorStatusFiles
 */
class DebtorStatus extends \yii\db\ActiveRecord
{
    const STATUSES = [
        'new' => 'Новое',
        'to_work' => 'В работу',
        'submitted_to_court' => 'Подано в суд',
        'adjudicated' => 'Вынесено решение',
        'application_withdrawn' => 'Заявление отозвано',
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'debtor_status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['submitted_to_court_start'], 'safe'],
            [['adjudicated_decision', 'application_withdrawn_reason'], 'string'],
            [['status', 'adjudicated_result'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'status' => Yii::t('app', 'Тип статуса'),
            'submitted_to_court_start' => Yii::t('app', 'Начало суда'),
            'adjudicated_result' => Yii::t('app', 'Результат суда'),
            'adjudicated_decision' => Yii::t('app', 'Решение суда'),
            'application_withdrawn_reason' => Yii::t('app', 'Причина отзыва заявления'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDebtors()
    {
        return $this->hasMany(Debtor::className(), ['status_id' => 'id'])->inverseOf('status');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDebtorStatusFiles()
    {
        return $this->hasMany(DebtorStatusFiles::className(), ['debtor_status_id' => 'id'])->inverseOf('debtorStatus');
    }

    protected static function prepareStatusName($statusId, $uppercase)
    {
        $status = self::STATUSES[$statusId];
        if ($uppercase) {
            $status = mb_strtoupper($status, Yii::$app->charset);
        }
        return $status;
    }

    public function getStatusName($uppercase = false)
    {
        return self::prepareStatusName($this->status, $uppercase);
    }

    public static function getStatusByDebtor(Debtor $debtor, $uppercase = false)
    {
        return empty($debtor->status)
            ? self::prepareStatusName('new', $uppercase)
            : $debtor->status->getStatusName(true);
    }
}
