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
            'debtor_id' => Yii::t('app', 'Debtor ID'),
            'amount' => Yii::t('app', 'Amount'),
            'amount_additional_services' => Yii::t('app', 'Amount Additional Services'),
            'date' => Yii::t('app', 'Date'),
            'payment_date' => Yii::t('app', 'Payment Date'),
            'public_service_id' => Yii::t('app', 'Public Service ID'),
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
}