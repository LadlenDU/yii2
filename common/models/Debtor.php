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
 * @property string $region
 * @property string $regionId
 * @property string $district
 * @property string $districtId
 * @property string $city
 * @property string $cityId
 * @property string $street
 * @property string $streetId
 * @property string $building
 * @property string $buildingId
 * @property string $appartment
 * @property string $phone
 * @property string $LS_EIRC
 * @property string $LS_IKU_provider
 * @property string $IKU
 * @property double $space_common
 * @property double $space_living
 * @property integer $privatized
 * @property integer $location_id
 *
 * @property DebtDetails[] $debtDetails
 * @property Location $location
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
            [['privatized', 'location_id'], 'integer'],
            [['first_name', 'second_name', 'patronymic', 'name_mixed', 'address', 'region', 'regionId', 'district', 'districtId', 'city', 'cityId', 'street', 'streetId', 'building', 'buildingId', 'appartment', 'phone', 'LS_EIRC', 'LS_IKU_provider', 'IKU'], 'string', 'max' => 255],
            [['location_id'], 'exist', 'skipOnError' => true, 'targetClass' => Location::className(), 'targetAttribute' => ['location_id' => 'id']],
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
            'region' => Yii::t('app', 'Область'),
            'regionId' => Yii::t('app', 'Region ID'),
            'district' => Yii::t('app', 'Район'),
            'districtId' => Yii::t('app', 'District ID'),
            'city' => Yii::t('app', 'Город'),
            'cityId' => Yii::t('app', 'City ID'),
            'street' => Yii::t('app', 'Улица'),
            'streetId' => Yii::t('app', 'Street ID'),
            'building' => Yii::t('app', 'Строение'),
            'buildingId' => Yii::t('app', 'Building ID'),
            'appartment' => Yii::t('app', 'Квартира'),
            'phone' => Yii::t('app', 'Телефон'),
            'LS_EIRC' => Yii::t('app', 'ЛС ЕИРЦ'),
            'LS_IKU_provider' => Yii::t('app', 'ЛС ИКУ/поставщика'),
            'IKU' => Yii::t('app', 'ИКУ'),
            'space_common' => Yii::t('app', 'Общая площадь'),
            'space_living' => Yii::t('app', 'Жилая площадь'),
            'privatized' => Yii::t('app', 'Приватизировано'),
            'location_id' => Yii::t('app', 'Location ID'),
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
    public function getLocation()
    {
        return $this->hasOne(Location::className(), ['id' => 'location_id'])->inverseOf('debtors');
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

    /**
     * @inheritdoc
     * @return DebtorQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DebtorQuery(get_called_class());
    }
}
