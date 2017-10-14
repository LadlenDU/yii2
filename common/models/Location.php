<?php

namespace common\models;

use Yii;
use common\models\info\Company;

/**
 * This is the model class for table "location".
 *
 * @property integer $id
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
 * @property string $zip_code
 * @property string $full_address
 *
 * @property Company[] $companies
 * @property Company[] $companies0
 * @property Debtor[] $debtors
 * @property UserInfo[] $userInfos
 */
class Location extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'location';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['region', 'regionId', 'district', 'districtId', 'city', 'cityId', 'street', 'streetId', 'building', 'buildingId', 'appartment', 'zip_code', 'full_address'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'region' => Yii::t('app', 'Регион (область)'),
            'regionId' => Yii::t('app', 'Код региона (области)'),
            'district' => Yii::t('app', 'Район'),
            'districtId' => Yii::t('app', 'Код района'),
            'city' => Yii::t('app', 'Город (населённый пункт)'),
            'cityId' => Yii::t('app', 'Код города (населённого пункта)'),
            'street' => Yii::t('app', 'Улица'),
            'streetId' => Yii::t('app', 'Код улицы'),
            'building' => Yii::t('app', 'Дом (строение)'),
            'buildingId' => Yii::t('app', 'Код дома (строения)'),
            'appartment' => Yii::t('app', 'Квартира'),
            'zip_code' => Yii::t('app', 'Почтовый индекс'),
            'full_address' => Yii::t('app', 'Произвольная строка адреса'),
            'address' => Yii::t('app', 'Адрес'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanies()
    {
        return $this->hasMany(Company::className(), ['actual_address_location_id' => 'id'])->inverseOf('actualAddressLocation');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanies0()
    {
        return $this->hasMany(Company::className(), ['legal_address_location_id' => 'id'])->inverseOf('legalAddressLocation');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDebtors()
    {
        return $this->hasMany(Debtor::className(), ['location_id' => 'id'])->inverseOf('location');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserInfos()
    {
        return $this->hasMany(UserInfo::className(), ['location_id' => 'id'])->inverseOf('location');
    }

    /**
     * @inheritdoc
     * @return LocationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LocationQuery(get_called_class());
    }

    public function getAddress()
    {
        return $this->street . ' ' . $this->building . ' ' . $this->appartment;
    }
}
