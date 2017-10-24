<?php

namespace common\models\info;

use Yii;
use common\models\Name;
use common\models\Location;
use common\models\UserInfo;
use common\models\UserInfoCompany;

/**
 * This is the model class for table "company".
 *
 * @property integer $id
 * @property string $full_name
 * @property string $short_name
 * @property integer $legal_address_location_id
 * @property integer $postal_address_location_id
 * @property integer $actual_address_location_id
 * @property string $INN
 * @property string $KPP
 * @property string $BIK
 * @property string $OGRN
 * @property string $OGRN_IP_type
 * @property string $OGRN_IP_number
 * @property string $OGRN_IP_date
 * @property string $OGRN_IP_registered_company
 * @property string $checking_account
 * @property string $correspondent_account
 * @property string $full_bank_name
 * @property integer $CEO
 * @property string $operates_on_the_basis_of
 * @property string $phone
 * @property string $fax
 * @property string $email
 * @property string $site
 * @property integer $company_type_id
 * @property integer $OKOPF_id
 * @property integer $tax_system_id
 *
 * @property Name $cEO
 * @property OKOPF $oKOPF
 * @property Location $actualAddressLocation
 * @property CompanyType $companyType
 * @property Location $legalAddressLocation
 * @property Location $postalAddressLocation
 * @property TaxSystem $taxSystem
 * @property CompanyCompanyFiles[] $companyCompanyFiles
 * @property CompanyFiles[] $companyFiles
 * @property CompanyPhone[] $companyPhones
 * @property UserInfo[] $userInfos
 * @property UserInfoCompany[] $userInfoCompanies
 * @property UserInfo[] $userInfos0
 */
class Company extends \yii\db\ActiveRecord
{
    public $company_files = [];

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
            [['full_name', 'short_name', 'company_type_id', 'tax_system_id'], 'required'],
            [['legal_address_location_id', 'postal_address_location_id', 'actual_address_location_id', 'OGRN_IP_type', 'CEO', 'company_type_id', 'OKOPF_id', 'tax_system_id'], 'integer'],
            [['OGRN_IP_date'], 'safe'],
            [['company_files'], 'safe'],
            [['site'], 'string'],
            [['full_name', 'short_name', 'INN', 'KPP', 'BIK', 'OGRN', 'OGRN_IP_number', 'OGRN_IP_registered_company', 'checking_account', 'correspondent_account', 'full_bank_name', 'operates_on_the_basis_of', 'phone', 'fax', 'email'], 'string', 'max' => 255],
            [['CEO'], 'exist', 'skipOnError' => true, 'targetClass' => Name::className(), 'targetAttribute' => ['CEO' => 'id']],
            [['OKOPF_id'], 'exist', 'skipOnError' => true, 'targetClass' => OKOPF::className(), 'targetAttribute' => ['OKOPF_id' => 'id']],
            [['actual_address_location_id'], 'exist', 'skipOnError' => true, 'targetClass' => Location::className(), 'targetAttribute' => ['actual_address_location_id' => 'id']],
            [['company_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => CompanyType::className(), 'targetAttribute' => ['company_type_id' => 'id']],
            [['legal_address_location_id'], 'exist', 'skipOnError' => true, 'targetClass' => Location::className(), 'targetAttribute' => ['legal_address_location_id' => 'id']],
            [['postal_address_location_id'], 'exist', 'skipOnError' => true, 'targetClass' => Location::className(), 'targetAttribute' => ['postal_address_location_id' => 'id']],
            [['tax_system_id'], 'exist', 'skipOnError' => true, 'targetClass' => TaxSystem::className(), 'targetAttribute' => ['tax_system_id' => 'id']],
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
            'postal_address_location_id' => Yii::t('app', 'Почтовый адрес'),
            'actual_address_location_id' => Yii::t('app', 'Фактический адрес'),
            'INN' => Yii::t('app', 'ИНН'),
            'KPP' => Yii::t('app', 'КПП'),
            'BIK' => Yii::t('app', 'БИК'),
            'OGRN' => Yii::t('app', 'ОГРН'),
            'OGRN_IP_type' => Yii::t('app', 'comment(\"Тип: ОГРН(0) или ОГРНИП(1)'),
            'OGRN_IP_number' => Yii::t('app', 'Номер ОГРН / ОГРНИП'),
            'OGRN_IP_date' => Yii::t('app', 'Дата ОГРН / ОГРНИП'),
            'OGRN_IP_registered_company' => Yii::t('app', 'Наименование зарегистрировавшей организации ОГРН / ОГРНИП'),
            'checking_account' => Yii::t('app', 'Расчетный счет'),
            'correspondent_account' => Yii::t('app', 'Корреспондентский счет'),
            'full_bank_name' => Yii::t('app', 'Полное наименование банка'),
            'CEO' => Yii::t('app', 'Генеральный директор'),
            'operates_on_the_basis_of' => Yii::t('app', 'Действует на основании'),
            'phone' => Yii::t('app', 'Телефон'),
            'fax' => Yii::t('app', 'Факс'),
            'email' => Yii::t('app', 'E-mail'),
            'site' => Yii::t('app', 'Сайт'),
            'company_type_id' => Yii::t('app', 'Тип организации'),
            'OKOPF_id' => Yii::t('app', 'ОКОПФ'),
            'tax_system_id' => Yii::t('app', 'Система налогообложения'),
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
    public function getOKOPF()
    {
        return $this->hasOne(OKOPF::className(), ['id' => 'OKOPF_id'])->inverseOf('companies');
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
    public function getCompanyType()
    {
        return $this->hasOne(CompanyType::className(), ['id' => 'company_type_id'])->inverseOf('companies');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLegalAddressLocation()
    {
        return $this->hasOne(Location::className(), ['id' => 'legal_address_location_id'])->inverseOf('companies0');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostalAddressLocation()
    {
        return $this->hasOne(Location::className(), ['id' => 'postal_address_location_id'])->inverseOf('companies1');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaxSystem()
    {
        return $this->hasOne(TaxSystem::className(), ['id' => 'tax_system_id'])->inverseOf('companies');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyCompanyFiles()
    {
        return $this->hasMany(CompanyCompanyFiles::className(), ['company_id' => 'id'])->inverseOf('company');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyFiles()
    {
        return $this->hasMany(CompanyFiles::className(), ['id' => 'company_files_id'])->viaTable('company_company_files', ['company_id' => 'id']);
        //return $this->hasOne(CompanyFiles::className(), ['id' => 'company_files_id'])->viaTable('company_company_files', ['company_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyPhones()
    {
        return $this->hasMany(CompanyPhone::className(), ['company_id' => 'id'])->inverseOf('company');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserInfos()
    {
        return $this->hasMany(UserInfo::className(), ['primary_company' => 'id'])->inverseOf('primaryCompany');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserInfoCompanies()
    {
        return $this->hasMany(UserInfoCompany::className(), ['company_id' => 'id'])->inverseOf('company');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserInfos0()
    {
        return $this->hasMany(UserInfo::className(), ['id' => 'user_info_id'])->viaTable('user_info_company', ['company_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return CompanyQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CompanyQuery(get_called_class());
    }
}
