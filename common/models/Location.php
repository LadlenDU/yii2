<?php

namespace common\models;

use Yii;

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
 * @property string $zip_code
 * @property string $arbitraty
 *
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
            [['region', 'regionId', 'district', 'districtId', 'city', 'cityId', 'street', 'streetId', 'building', 'buildingId', 'zip_code', 'arbitraty'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'region' => Yii::t('app', 'регион (область)'),
            'regionId' => Yii::t('app', 'код региона (области)'),
            'district' => Yii::t('app', 'район'),
            'districtId' => Yii::t('app', 'код района'),
            'city' => Yii::t('app', 'город (населённый пункт)'),
            'cityId' => Yii::t('app', 'код города (населённого пункта)'),
            'street' => Yii::t('app', 'улица'),
            'streetId' => Yii::t('app', 'код улицы'),
            'building' => Yii::t('app', 'дом (строение)'),
            'buildingId' => Yii::t('app', 'код дома (строения)'),
            'zip_code' => Yii::t('app', 'почтовый индекс'),
            'arbitraty' => Yii::t('app', 'произвольная строка адреса (если не дано разделение по элементам)'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserInfos()
    {
        return $this->hasMany(UserInfo::className(), ['location_id' => 'id'])->inverseOf('location');
    }
}
