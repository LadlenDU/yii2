<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "debt_details".
 *
 * @property integer $id
 * @property integer $debtor_id
 * @property string $amount
 * @property string $amount_additional_services
 * @property string $date
 * @property string $payment_date
 * @property integer $public_service_id
 *
 * @property Debtor $debtor
 * @property PublicService $publicService
 */
class DebtDetails extends \yii\db\ActiveRecord
{
    const DEBT_DIVISION_VALUE = 20000;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'debt_details';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['debtor_id', 'public_service_id'], 'integer'],
            [['amount', 'amount_additional_services'], 'number'],
            [['date', 'payment_date'], 'safe'],
            [['debtor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Debtor::className(), 'targetAttribute' => ['debtor_id' => 'id']],
            [['public_service_id'], 'exist', 'skipOnError' => true, 'targetClass' => PublicService::className(), 'targetAttribute' => ['public_service_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'debtor_id' => Yii::t('app', 'ID должника'),
            'amount' => Yii::t('app', 'Сумма долга'),
            'amount_additional_services' => Yii::t('app', 'Сумма долга с допуслугами'),
            'date' => Yii::t('app', 'Дата'),
            'payment_date' => Yii::t('app', 'Дата оплаты'),
            'public_service_id' => Yii::t('app', 'Public Service ID'),
            'debtor.LS_IKU_provider' => 'TTYYTU',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDebtor()
    {
        return $this->hasOne(Debtor::className(), ['id' => 'debtor_id'])->inverseOf('debtDetails');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPublicService()
    {
        return $this->hasOne(PublicService::className(), ['id' => 'public_service_id'])->inverseOf('debtDetails');
    }

    public function calculateStateFee()
    {
        if ($this->amount < self::DEBT_DIVISION_VALUE) {
            $fee = $this->amount / 100 * 4;
            $fee = ($fee < 400) ? 400 : $fee;
        } else {
            $midVal = $this->amount - self::DEBT_DIVISION_VALUE;
            $fee = $midVal / 100 * 3 + 800;
        }

        return $fee;
    }
}
