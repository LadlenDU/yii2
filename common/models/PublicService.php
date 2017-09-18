<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "public_service".
 *
 * @property integer $id
 * @property string $name
 *
 * @property DebtDetails[] $debtDetails
 * @property DebtorPublicService[] $debtorPublicServices
 * @property Debtor[] $debtors
 */
class PublicService extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'public_service';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDebtDetails()
    {
        return $this->hasMany(DebtDetails::className(), ['public_service_id' => 'id'])->inverseOf('publicService');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDebtorPublicServices()
    {
        return $this->hasMany(DebtorPublicService::className(), ['public_service_id' => 'id'])->inverseOf('publicService');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDebtors()
    {
        return $this->hasMany(Debtor::className(), ['id' => 'debtor_id'])->viaTable('debtor_public_service', ['public_service_id' => 'id']);
    }
}
