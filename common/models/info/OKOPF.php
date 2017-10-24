<?php

namespace common\models\info;

use Yii;

/**
 * This is the model class for table "OKOPF".
 *
 * @property integer $id
 * @property string $code
 * @property string $name
 *
 * @property Company[] $companies
 */
class OKOPF extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'OKOPF';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['code', 'name'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['code'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'code' => Yii::t('app', 'Code'),
            'name' => Yii::t('app', 'Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanies()
    {
        return $this->hasMany(Company::className(), ['OKOPF_id' => 'id'])->inverseOf('oKOPF');
    }
}
