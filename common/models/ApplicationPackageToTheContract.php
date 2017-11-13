<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "application_package_to_the_contract".
 *
 * @property integer $id
 * @property string $number
 * @property string $name
 *
 * @property ApplicationPackageToTheContractUser[] $applicationPackageToTheContractUsers
 * @property User[] $users
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
            [['number', 'name'], 'required'],
            [['number'], 'integer'],
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
            'number' => Yii::t('app', 'Номер по порядку'),
            'name' => Yii::t('app', 'Название пакета приложений'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationPackageToTheContractUsers()
    {
        return $this->hasMany(ApplicationPackageToTheContractUser::className(), ['application_package_to_the_contract_id' => 'id'])->inverseOf('applicationPackageToTheContract');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('application_package_to_the_contract_user', ['application_package_to_the_contract_id' => 'id']);
    }
}
