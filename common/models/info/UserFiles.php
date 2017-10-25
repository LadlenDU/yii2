<?php

namespace common\models\info;

use Yii;
use common\models\UserInfo;
use common\models\UserInfoUserFiles;

/**
 * This is the model class for table "user_files".
 *
 * @property integer $id
 * @property string $content
 * @property string $name
 * @property string $mime_type
 *
 * @property UserInfoUserFiles[] $userInfoUserFiles
 * @property UserInfo[] $userInfos
 */
class UserFiles extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_files';
    }

    public function behaviors()
    {
        return [
            // anonymous behavior, behavior class name only
            \common\models\FileUploadBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'], 'string'],
            [['name', 'mime_type'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'content' => Yii::t('app', 'Content'),
            'name' => Yii::t('app', 'Name'),
            'mime_type' => Yii::t('app', 'Mime Type'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserInfoUserFiles()
    {
        return $this->hasMany(UserInfoUserFiles::className(), ['user_files_id' => 'id'])->inverseOf('userFiles');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserInfos()
    {
        return $this->hasMany(UserInfo::className(), ['id' => 'user_info_id'])->viaTable('user_info_user_files', ['user_files_id' => 'id']);
    }
}
