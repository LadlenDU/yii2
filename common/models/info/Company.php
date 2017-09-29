<?php

namespace common\models\info;

use Yii;
use common\models\Name;
use common\models\Location;

/**
 * This is the model class for table "company".
 *
 * @property integer $id
 * @property string $full_name
 * @property string $short_name
 * @property integer $legal_address_location_id
 * @property integer $actual_address_location_id
 * @property string $INN
 * @property string $KPP
 * @property string $BIK
 * @property string $OGRN
 * @property string $checking_account
 * @property string $correspondent_account
 * @property string $full_bank_name
 * @property integer $CEO
 * @property string $operates_on_the_basis_of
 * @property string $phone
 * @property string $fax
 * @property string $email
 *
 * @property Name $cEO
 * @property Location $actualAddressLocation
 * @property Location $legalAddressLocation
 */
class Company extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'company';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['full_name'], 'required'],
            [['legal_address_location_id', 'actual_address_location_id', 'CEO'], 'integer'],
            [['full_name', 'short_name', 'INN', 'KPP', 'BIK', 'OGRN', 'checking_account', 'correspondent_account', 'full_bank_name', 'operates_on_the_basis_of', 'phone', 'fax', 'email'], 'string', 'max' => 255],
            [['CEO'], 'exist', 'skipOnError' => true, 'targetClass' => Name::className(), 'targetAttribute' => ['CEO' => 'id']],
            [['actual_address_location_id'], 'exist', 'skipOnError' => true, 'targetClass' => Location::className(), 'targetAttribute' => ['actual_address_location_id' => 'id']],
            [['legal_address_location_id'], 'exist', 'skipOnError' => true, 'targetClass' => Location::className(), 'targetAttribute' => ['legal_address_location_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'full_name' => Yii::t('app', 'Полное наименование'),
            'short_name' => Yii::t('app', 'Сокращенное наименование'),
            'legal_address_location_id' => Yii::t('app', 'Юридический адрес'),
            'actual_address_location_id' => Yii::t('app', 'Фактический адрес'),
            'INN' => Yii::t('app', 'ИНН'),
            'KPP' => Yii::t('app', 'КПП'),
            'BIK' => Yii::t('app', 'БИК'),
            'OGRN' => Yii::t('app', 'ОГРН'),
            'checking_account' => Yii::t('app', 'Расчетный счет'),
            'correspondent_account' => Yii::t('app', 'Корреспондентский счет'),
            'full_bank_name' => Yii::t('app', 'Полное наименование банка'),
            'CEO' => Yii::t('app', 'Генеральный директор'),
            'operates_on_the_basis_of' => Yii::t('app', 'Действует на основании'),
            'phone' => Yii::t('app', 'Телефон'),
            'fax' => Yii::t('app', 'Факс'),
            'email' => Yii::t('app', 'E-mail'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCEO()
    {
        return $this->hasOne(Name::className(), ['id' => 'CEO'])->inverseOf('companies');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActualAddressLocation()
    {
        return $this->hasOne(Location::className(), ['id' => 'actual_address_location_id'])->inverseOf('companies');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLegalAddressLocation()
    {
        return $this->hasOne(Location::className(), ['id' => 'legal_address_location_id'])->inverseOf('companies0');
    }
}
