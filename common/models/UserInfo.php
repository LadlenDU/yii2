<?php

namespace common\models;

use Yii;
use common\models\info\Individual;
use common\models\info\IndividualEntrepreneur;
use common\models\info\LegalEntity;
//use common\models\info\TariffPlan;
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
 *
 * @property Individual[] $individuals
 * @property IndividualEntrepreneur[] $individualEntrepreneurs
 * @property LegalEntity[] $legalEntities
 * @property RegistrationType $registrationType
 * @property TariffPlan $tariffPlan
 * @property User $user
 */
class UserInfo extends \yii\db\ActiveRecord
{
    const SCENARIO_SELECT_REGISTRATION_TYPE = 'select_registration_type';

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
            [['user_id', 'complete', 'registration_type_id', 'tariff_plan_id'], 'integer'],
            [['balance'], 'number'],
            [['user_id'], 'unique'],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIndividuals()
    {
        return $this->hasMany(Individual::className(), ['user_info_id' => 'id'])->inverseOf('userInfo');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIndividualEntrepreneurs()
    {
        return $this->hasMany(IndividualEntrepreneur::className(), ['user_info_id' => 'id'])->inverseOf('userInfo');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLegalEntities()
    {
        return $this->hasMany(LegalEntity::className(), ['user_info_id' => 'id'])->inverseOf('userInfo');
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
}
