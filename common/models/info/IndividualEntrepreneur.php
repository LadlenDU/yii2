<?php

namespace common\models\info;

use Yii;
use common\models\UserInfo;

/**
 * This is the model class for table "individual_entrepreneur".
 *
 * @property integer $id
 * @property integer $user_info_id
 * @property string $full_name
 * @property string $OGRN
 * @property string $INN
 * @property string $BIC
 * @property string $checking_account_num
 *
 * @property UserInfo $userInfo
 */
class IndividualEntrepreneur extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'individual_entrepreneur';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_info_id'], 'required'],
            [['user_info_id'], 'integer'],
            [['full_name'], 'string', 'max' => 255],
            [['OGRN', 'INN', 'BIC', 'checking_account_num'], 'string', 'max' => 40],
            [['user_info_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserInfo::className(), 'targetAttribute' => ['user_info_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_info_id' => Yii::t('app', 'User Info ID'),
            'full_name' => Yii::t('app', 'Full Name'),
            'OGRN' => Yii::t('app', 'Ogrn'),
            'INN' => Yii::t('app', 'Inn'),
            'BIC' => Yii::t('app', 'Bic'),
            'checking_account_num' => Yii::t('app', 'Checking Account Num'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserInfo()
    {
        return $this->hasOne(UserInfo::className(), ['id' => 'user_info_id'])->inverseOf('individualEntrepreneurs');
    }
}
