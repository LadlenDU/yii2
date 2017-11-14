<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "application_package_to_the_contract".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $number
 * @property string $name
 *
 * @property User $user
 * @property ApplicationPackageToTheContractDebtor[] $applicationPackageToTheContractDebtors
 * @property Debtor[] $debtors
 */
class ApplicationPackageToTheContract extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'application_package_to_the_contract';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'number'], 'integer'],
            [['number', 'name'], 'required'],
            [['name'], 'string', 'max' => 255],
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
            'user_id' => Yii::t('app', 'User ID'),
            'number' => Yii::t('app', 'Номер по порядку'),
            'name' => Yii::t('app', 'Название пакета приложений'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id'])->inverseOf('applicationPackageToTheContracts');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationPackageToTheContractDebtors()
    {
        return $this->hasMany(ApplicationPackageToTheContractDebtor::className(), ['application_package_to_the_contract_id' => 'id'])->inverseOf('applicationPackageToTheContract');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDebtors()
    {
        return $this->hasMany(Debtor::className(), ['id' => 'debtor_id'])->viaTable('application_package_to_the_contract_debtor', ['application_package_to_the_contract_id' => 'id']);
    }
}
