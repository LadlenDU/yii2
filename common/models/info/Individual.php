<?php

namespace common\models\info;

use Yii;
use common\models\UserInfo;

/**
 * This is the model class for table "individual".
 *
 * @property integer $id
 * @property integer $user_info_id
 * @property string $full_name
 * @property string $INN
 * @property string $checking_account_num
 * @property string $birthday
 *
 * @property UserInfo $userInfo
 */
class Individual extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'individual';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_info_id'], 'required'],
            [['user_info_id'], 'integer'],
            [['birthday'], 'safe'],
            [['full_name'], 'string', 'max' => 255],
            [['INN', 'checking_account_num'], 'string', 'max' => 40],
            [['user_info_id'], 'unique'],
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
            'full_name' => Yii::t('app', 'ФИО'),
            'INN' => Yii::t('app', 'ИНН'),
            'checking_account_num' => Yii::t('app', '№ расчетного счета'),
            'birthday' => Yii::t('app', 'День рождения'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserInfo()
    {
        return $this->hasOne(UserInfo::className(), ['id' => 'user_info_id'])->inverseOf('individual');
    }
}
