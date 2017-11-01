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
 * @property Company[] $companies1
 * @property Debtor[] $debtors
 * @property House[] $houses
 * @property ServicedHouses[] $servicedHouses
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
    public function getCompanies1()
    {
        return $this->hasMany(Company::className(), ['postal_address_location_id' => 'id'])->inverseOf('postalAddressLocation');
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
    public function getHouses()
    {
        return $this->hasMany(House::className(), ['location_id' => 'id'])->inverseOf('location');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServicedHouses()
    {
        return $this->hasMany(ServicedHouses::className(), ['location_id' => 'id'])->inverseOf('location');
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

    /*public function getAddress()
    {
        return $this->street . ' д. ' . $this->building . ' кв. ' . $this->appartment;
    }*/

    public function createFullAddress()
    {
        if ($this->full_address) {
            return $this->full_address;
        }

        $aP1 = [];
        $this->zip_code ? ($aP1[] = $this->zip_code) : null;
        $this->region ? ($aP1[] = $this->region) : null;
        $this->district ? ($aP1[] = $this->district) : null;
        $this->city ? ($aP1[] = $this->city) : null;

        $aP2 = [];

        $addressP1 = implode(', ', $aP1);
        $addressP2 = $this->street;
        if ($this->building) {
            $addressP2 .= Yii::t('app', ' д. ') . $this->building;
        }
        if ($this->appartment) {
            $addressP2 .= Yii::t('app', ' кв. ') . $this->appartment;
        }

        $addressP1 ? ($aP2[] = $addressP1) : null;
        $addressP2 ? ($aP2[] = $addressP2) : null;

        $address = implode(', ', $aP2);

        return $address ?: yii::$app->formatter->nullDisplay;
    }
}
