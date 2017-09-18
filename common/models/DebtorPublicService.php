<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "debtor_public_service".
 *
 * @property integer $debtor_id
 * @property integer $public_service_id
 *
 * @property Debtor $debtor
 * @property PublicService $publicService
 */
class DebtorPublicService extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'debtor_public_service';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['debtor_id', 'public_service_id'], 'required'],
            [['debtor_id', 'public_service_id'], 'integer'],
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
            'debtor_id' => Yii::t('app', 'Debtor ID'),
            'public_service_id' => Yii::t('app', 'Public Service ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDebtor()
    {
        return $this->hasOne(Debtor::className(), ['id' => 'debtor_id'])->inverseOf('debtorPublicServices');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPublicService()
    {
        return $this->hasOne(PublicService::className(), ['id' => 'public_service_id'])->inverseOf('debtorPublicServices');
    }
}
