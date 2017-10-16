<?php

namespace common\models;

use Yii;
use common\models\info\Company;

/**
 * This is the model class for table "name".
 *
 * @property integer $id
 * @property string $first_name
 * @property string $second_name
 * @property string $patronymic
 * @property string $full_name
 *
 * @property Company[] $companies
 * @property Debtor[] $debtors
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
            'first_name' => Yii::t('app', 'Имя'),
            'second_name' => Yii::t('app', 'Фамилия'),
            'patronymic' => Yii::t('app', 'Отчество'),
            'full_name' => Yii::t('app', 'ФИО'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanies()
    {
        return $this->hasMany(Company::className(), ['CEO' => 'id'])->inverseOf('cEO');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDebtors()
    {
        return $this->hasMany(Debtor::className(), ['name_id' => 'id'])->inverseOf('name');
    }

    /**
     * @inheritdoc
     * @return NameQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NameQuery(get_called_class());
    }

    public function createFullName()
    {
        if ($this->full_name) {
            return $this->full_name;
        }

        $name = implode(' ', [$this->second_name, $this->first_name, $this->patronymic]);

        if (!$name) {
            $name = yii::$app->formatter->nullDisplay;
        }

        return $name;
    }
}
