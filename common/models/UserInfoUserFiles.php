<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_info_user_files".
 *
 * @property integer $user_info_id
 * @property integer $user_files_id
 *
 * @property UserFiles $userFiles
 * @property UserInfo $userInfo
 */
class UserInfoUserFiles extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_info_user_files';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_info_id', 'user_files_id'], 'required'],
            [['user_info_id', 'user_files_id'], 'integer'],
            [['user_files_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserFiles::className(), 'targetAttribute' => ['user_files_id' => 'id']],
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
            'user_files_id' => Yii::t('app', 'User Files ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserFiles()
    {
        return $this->hasOne(UserFiles::className(), ['id' => 'user_files_id'])->inverseOf('userInfoUserFiles');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserInfo()
    {
        return $this->hasOne(UserInfo::className(), ['id' => 'user_info_id'])->inverseOf('userInfoUserFiles');
    }
}
