<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "court".
 *
 * @property integer $id
 * @property string $name
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
 * @property string $phone
 * @property string $name_of_payee
 * @property string $BIC
 * @property string $beneficiary_account_number
 * @property string $INN
 * @property string $KPP
 * @property string $OKTMO
 * @property string $beneficiary_bank_name
 * @property string $KBK
 * @property integer $user_id
 *
 * @property User $user
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
            [['user_id'], 'integer'],
            [['name', 'address', 'region', 'regionId', 'district', 'districtId', 'city', 'cityId', 'street', 'streetId', 'building', 'buildingId', 'phone', 'name_of_payee', 'BIC', 'beneficiary_account_number', 'INN', 'KPP', 'OKTMO', 'beneficiary_bank_name', 'KBK'], 'string', 'max' => 255],
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
            'name' => Yii::t('app', 'Наименование'),
            'address' => Yii::t('app', 'Адрес одной строкой'),
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
            'phone' => Yii::t('app', 'Телефон'),
            'name_of_payee' => Yii::t('app', 'Наименование получателя платежа'),
            'BIC' => Yii::t('app', 'БИК'),
            'beneficiary_account_number' => Yii::t('app', 'Номер счета получателя платежа'),
            'INN' => Yii::t('app', 'ИНН'),
            'KPP' => Yii::t('app', 'КПП'),
            'OKTMO' => Yii::t('app', 'ОКТМО'),
            'beneficiary_bank_name' => Yii::t('app', 'Наименование банка получателя платежа'),
            'KBK' => Yii::t('app', 'КБК'),
            'user_id' => Yii::t('app', 'ID пользователя'),
        ];
    }

    public function getFullAddress()
    {
        //TODO: адрес вынести в таблицу location
        $addr = trim(implode(', ', [$this->region, $this->district, $this->city, $this->street, $this->building]));
        if (!$addr) {
            $addr = '(Нет адреса)';
        }
        return $addr;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id'])->inverseOf('courts');
    }
}
