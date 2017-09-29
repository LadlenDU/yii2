<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_info_company".
 *
 * @property integer $user_info_id
 * @property integer $company_id
 *
 * @property Company $company
 * @property UserInfo $userInfo
 */
class UserInfoCompany extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_info_company';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_info_id', 'company_id'], 'required'],
            [['user_info_id', 'company_id'], 'integer'],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_id' => 'id']],
            [['user_info_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserInfo::className(), 'targetAttribute' => ['user_info_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_info_id' => Yii::t('app', 'User Info ID'),
            'company_id' => Yii::t('app', 'Company ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id'])->inverseOf('userInfoCompanies');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserInfo()
    {
        return $this->hasOne(UserInfo::className(), ['id' => 'user_info_id'])->inverseOf('userInfoCompanies');
    }
}
