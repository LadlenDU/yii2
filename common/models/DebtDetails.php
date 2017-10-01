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
 * @property string $incoming_balance_debit
 * @property string $incoming_balance_credit
 * @property string $charges_permanent
 * @property string $accrued_subsidies
 * @property string $one_time_charges
 * @property string $paid
 * @property string $paid_insurance
 * @property string $grants_paid
 * @property string $outgoing_balance_debit
 * @property string $outgoing_balance_credit
 * @property string $overdue_debts
 *
 * @property Debtor $debtor
 * @property PublicService $publicService
 */
class DebtDetails extends \yii\db\ActiveRecord
{
    //TODO: перенести в DebtDetailsExt
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
            [['amount', 'amount_additional_services', 'incoming_balance_debit', 'incoming_balance_credit', 'charges_permanent', 'accrued_subsidies', 'one_time_charges', 'paid', 'paid_insurance', 'grants_paid', 'outgoing_balance_debit', 'outgoing_balance_credit', 'overdue_debts'], 'number'],
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
            'incoming_balance_debit' => Yii::t('app', 'Входящее сальдо (дебет)'),
            'incoming_balance_credit' => Yii::t('app', 'Входящее сальдо (кредит)'),
            'charges_permanent' => Yii::t('app', 'Начисления постоянные'),
            'accrued_subsidies' => Yii::t('app', 'Начисленные субсидии'),
            'one_time_charges' => Yii::t('app', 'Начисления разовые'),
            'paid' => Yii::t('app', 'Оплачено'),
            'paid_insurance' => Yii::t('app', 'Оплачено страховки'),
            'grants_paid' => Yii::t('app', 'Оплачено субсидий'),
            'outgoing_balance_debit' => Yii::t('app', 'Исходящее сальдо (дебет)'),
            'outgoing_balance_credit' => Yii::t('app', 'Исходящее сальдо (кредит)'),
            'overdue_debts' => Yii::t('app', 'Просроченная задолженность'),
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
