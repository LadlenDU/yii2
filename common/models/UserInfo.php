<?php

namespace common\models;

use Yii;
use common\models\info\Individual;
use common\models\info\IndividualEntrepreneur;
use common\models\info\LegalEntity;
use common\models\TariffPlan;
use common\models\info\Company;
use common\models\info\UserFiles;
use dektrium\user\models\User;


/**
 * This is the model class for table "user_info".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $complete
 * @property integer $registration_type_id
 * @property string $balance
 * @property integer $tariff_plan_id
 * @property integer $location_id
 *
 * @property Individual $individual
 * @property IndividualEntrepreneur $individualEntrepreneur
 * @property LegalEntity $legalEntity
 * @property Location $location
 * @property RegistrationType $registrationType
 * @property TariffPlan $tariffPlan
 * @property User $user
 * @property UserInfoCompany[] $userInfoCompanies
 * @property Company[] $companies
 * @property UserInfoUserFiles[] $userInfoUserFiles
 * @property UserFiles[] $userFiles
 */
class UserInfo extends \yii\db\ActiveRecord
{
    const SCENARIO_SELECT_REGISTRATION_TYPE = 'select_registration_type';

    public $user_files = [];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_info';
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_SELECT_REGISTRATION_TYPE] = ['registration_type_id'];

        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'complete', 'registration_type_id', 'tariff_plan_id', 'location_id'], 'integer'],
            [['balance'], 'number'],
            [['user_id'], 'unique'],
            [['user_files'], 'safe'],
            [['location_id'], 'exist', 'skipOnError' => true, 'targetClass' => Location::className(), 'targetAttribute' => ['location_id' => 'id']],
            [['registration_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => RegistrationType::className(), 'targetAttribute' => ['registration_type_id' => 'id']],
            [['tariff_plan_id'], 'exist', 'skipOnError' => true, 'targetClass' => TariffPlan::className(), 'targetAttribute' => ['tariff_plan_id' => 'id']],
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
            'user_id' => Yii::t('app', 'User ID'),
            'complete' => Yii::t('app', 'Завершен ли процесс заполнения информации'),
            'registration_type_id' => Yii::t('app', 'Вариант регистрации'),
            'balance' => Yii::t('app', 'Balance'),
            'tariff_plan_id' => Yii::t('app', 'Tariff Plan ID'),
            'location_id' => Yii::t('app', 'Location ID'),
            'user_files' => Yii::t('app', 'Пользовательские файлы'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIndividual()
    {
        return $this->hasOne(Individual::className(), ['user_info_id' => 'id'])->inverseOf('userInfo');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIndividualEntrepreneur()
    {
        return $this->hasOne(IndividualEntrepreneur::className(), ['user_info_id' => 'id'])->inverseOf('userInfo');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLegalEntity()
    {
        return $this->hasOne(LegalEntity::className(), ['user_info_id' => 'id'])->inverseOf('userInfo');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocation()
    {
        return $this->hasOne(Location::className(), ['id' => 'location_id'])->inverseOf('userInfos');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegistrationType()
    {
        return $this->hasOne(RegistrationType::className(), ['id' => 'registration_type_id'])->inverseOf('userInfos');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTariffPlan()
    {
        return $this->hasOne(TariffPlan::className(), ['id' => 'tariff_plan_id'])->inverseOf('userInfos');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id'])->inverseOf('userInfo');
    }

    /**
     * Вернуть название (имя) в зависимости от типа регистрации.
     */
    public function getNameOfEntity()
    {
        $name = '';

        switch ($this->registrationType->id) {
            case 1: {
                $name = $this->legalEntity->company_name;
                break;
            }
            case 2: {
                $name = $this->individualEntrepreneur->full_name;
                break;
            }
            case 3: {
                $name = $this->individual->full_name;
                break;
            }
            default: {
                break;
            }
        }

        return $name;
    }

    public function getEntity()
    {
        $entity = false;

        switch ($this->registrationType->id) {
            case 1: {
                $entity = $this->legalEntity;
                break;
            }
            case 2: {
                $entity = $this->individualEntrepreneur;
                break;
            }
            case 3: {
                $entity = $this->individual;
                break;
            }
            default: {
                break;
            }
        }

        return $entity;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserInfoCompanies()
    {
        return $this->hasMany(UserInfoCompany::className(), ['user_info_id' => 'id'])->inverseOf('userInfo');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanies()
    {
        return $this->hasMany(Company::className(), ['id' => 'company_id'])->viaTable('user_info_company', ['user_info_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserInfoUserFiles()
    {
        return $this->hasMany(UserInfoUserFiles::className(), ['user_info_id' => 'id'])->inverseOf('userInfo');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserFiles()
    {
        return $this->hasMany(UserFiles::className(), ['id' => 'user_files_id'])->viaTable('user_info_user_files', ['user_info_id' => 'id']);
    }
}
