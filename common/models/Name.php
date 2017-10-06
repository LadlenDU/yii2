<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "name".
 *
 * @property integer $id
 * @property string $first_name
 * @property string $second_name
 * @property string $patronymic
 * @property string $full_name
 *
 * @property Company[] $companies
 * @property Debtor[] $debtors
 */
class Name extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'name';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['first_name', 'second_name', 'patronymic', 'full_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'first_name' => Yii::t('app', 'First Name'),
            'second_name' => Yii::t('app', 'Second Name'),
            'patronymic' => Yii::t('app', 'Patronymic'),
            'full_name' => Yii::t('app', 'Full Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanies()
    {
        return $this->hasMany(Company::className(), ['CEO' => 'id'])->inverseOf('cEO');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDebtors()
    {
        return $this->hasMany(Debtor::className(), ['name_id' => 'id'])->inverseOf('name');
    }

    /**
     * @inheritdoc
     * @return NameQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NameQuery(get_called_class());
    }
}
