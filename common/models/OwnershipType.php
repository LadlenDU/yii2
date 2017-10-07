<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ownership_type".
 *
 * @property integer $id
 * @property string $name
 *
 * @property Debtor[] $debtors
 */
class OwnershipType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ownership_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 40],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Название'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDebtors()
    {
        return $this->hasMany(Debtor::className(), ['ownership_type_id' => 'id'])->inverseOf('ownershipType');
    }
}
