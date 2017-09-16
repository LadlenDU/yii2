<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "registration_type".
 *
 * @property integer $id
 * @property string $name
 * @property string $short_name
 * @property string $table_name
 *
 * @property UserInfo[] $userInfos
 */
class RegistrationType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'registration_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255],
            [['short_name'], 'string', 'max' => 10],
            [['table_name'], 'string', 'max' => 40],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'short_name' => Yii::t('app', 'Short Name'),
            'table_name' => Yii::t('app', 'Table Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserInfos()
    {
        return $this->hasMany(UserInfo::className(), ['registration_type_id' => 'id'])->inverseOf('registrationType');
    }

    public static function getIdNamePairs()
    {
        return ArrayHelper::map(self::find()->all(), 'id', 'name');
    }
}
