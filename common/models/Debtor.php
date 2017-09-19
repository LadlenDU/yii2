<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "debtor".
 *
 * @property integer $id
 * @property string $first_name
 * @property string $second_name
 * @property string $patronymic
 * @property string $name_mixed
 * @property string $address
 * @property string $locality
 * @property string $street
 * @property string $house
 * @property string $appartment
 * @property string $phone
 * @property string $LS_EIRC
 * @property string $LS_IKU_provider
 * @property double $space_common
 * @property double $space_living
 * @property integer $privatized
 * @property integer $general_manager_id
 *
 * @property DebtDetails[] $debtDetails
 * @property GeneralManager $generalManager
 * @property DebtorPublicService[] $debtorPublicServices
 * @property PublicService[] $publicServices
 */
class Debtor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'debtor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['space_common', 'space_living'], 'number'],
            [['privatized', 'general_manager_id'], 'integer'],
            [['first_name', 'second_name', 'patronymic', 'name_mixed', 'address', 'locality', 'street', 'house', 'appartment', 'phone', 'LS_EIRC', 'LS_IKU_provider'], 'string', 'max' => 255],
            [['general_manager_id'], 'exist', 'skipOnError' => true, 'targetClass' => GeneralManager::className(), 'targetAttribute' => ['general_manager_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'first_name' => Yii::t('app', 'Имя'),
            'second_name' => Yii::t('app', 'Фамилия'),
            'patronymic' => Yii::t('app', 'Отчество'),
            'name_mixed' => Yii::t('app', 'ФИО'),
            'address' => Yii::t('app', 'Адрес'),
            'locality' => Yii::t('app', 'Населённый пункт'),
            'street' => Yii::t('app', 'Улица'),
            'house' => Yii::t('app', 'Дом'),
            'appartment' => Yii::t('app', 'Квартира'),
            'phone' => Yii::t('app', 'Телефон'),
            'LS_EIRC' => Yii::t('app', 'ЛС ЕИРЦ'),
            'LS_IKU_provider' => Yii::t('app', 'ЛС ИКУ/поставщика'),
            'IKU' => Yii::t('app', 'ИКУ'),
            'space_common' => Yii::t('app', 'Общая площадь'),
            'space_living' => Yii::t('app', 'Жилая площадь'),
            'privatized' => Yii::t('app', 'Приватизировано'),
            'general_manager_id' => Yii::t('app', 'ID главного менеджера'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDebtDetails()
    {
        return $this->hasMany(DebtDetails::className(), ['debtor_id' => 'id'])->inverseOf('debtor');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGeneralManager()
    {
        return $this->hasOne(GeneralManager::className(), ['id' => 'general_manager_id'])->inverseOf('debtors');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDebtorPublicServices()
    {
        return $this->hasMany(DebtorPublicService::className(), ['debtor_id' => 'id'])->inverseOf('debtor');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPublicServices()
    {
        return $this->hasMany(PublicService::className(), ['id' => 'public_service_id'])->viaTable('debtor_public_service', ['debtor_id' => 'id']);
    }
}
