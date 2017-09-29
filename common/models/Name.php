<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "name".
 *
 * @property integer $id
 * @property string $first_name
 * @property string $second_name
 * @property string $patronymic
 * @property string $full_name
 */
class Name extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'name';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['first_name', 'second_name', 'patronymic', 'full_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'first_name' => Yii::t('app', 'First Name'),
            'second_name' => Yii::t('app', 'Second Name'),
            'patronymic' => Yii::t('app', 'Patronymic'),
            'full_name' => Yii::t('app', 'Full Name'),
        ];
    }
}
