<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tariff_plan".
 *
 * @property integer $id
 * @property string $name
 *
 * @property UserInfo[] $userInfos
 */
class TariffPlan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tariff_plan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserInfos()
    {
        return $this->hasMany(UserInfo::className(), ['tariff_plan_id' => 'id'])->inverseOf('tariffPlan');
    }
}
