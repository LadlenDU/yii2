<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "court".
 *
 * @property integer $id
 * @property string $name
 * @property string $address
 * @property string $district
 * @property string $districtId
 * @property string $city
 * @property string $cityId
 * @property string $street
 * @property string $streetId
 * @property string $building
 * @property string $buildingId
 * @property string $phone
 * @property string $name_of_payee
 * @property string $BIC
 * @property string $beneficiary_account_number
 * @property string $INN
 * @property string $KPP
 * @property string $OKTMO
 * @property string $beneficiary_bank_name
 * @property string $KBK
 */
class Court extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'court';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'address', 'district', 'districtId', 'city', 'cityId', 'street', 'streetId', 'building', 'buildingId', 'phone', 'name_of_payee', 'BIC', 'beneficiary_account_number', 'INN', 'KPP', 'OKTMO', 'beneficiary_bank_name', 'KBK'], 'string', 'max' => 255],
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
            'address' => Yii::t('app', 'адрес - если был указан одной строкой'),
            'district' => Yii::t('app', 'район'),
            'districtId' => Yii::t('app', 'код района'),
            'city' => Yii::t('app', 'город (населённый пункт)'),
            'cityId' => Yii::t('app', 'код города (населённого пункта)'),
            'street' => Yii::t('app', 'улица'),
            'streetId' => Yii::t('app', 'код улицы'),
            'building' => Yii::t('app', 'дом (строение)'),
            'buildingId' => Yii::t('app', 'код дома (строения)'),
            'phone' => Yii::t('app', 'Phone'),
            'name_of_payee' => Yii::t('app', 'наименование получателя платежа'),
            'BIC' => Yii::t('app', 'БИК'),
            'beneficiary_account_number' => Yii::t('app', 'номер счета получателя платежа'),
            'INN' => Yii::t('app', 'ИНН'),
            'KPP' => Yii::t('app', 'КПП'),
            'OKTMO' => Yii::t('app', 'ОКТМО'),
            'beneficiary_bank_name' => Yii::t('app', 'наименование банка получателя платежа'),
            'KBK' => Yii::t('app', 'КБК'),
        ];
    }
}
