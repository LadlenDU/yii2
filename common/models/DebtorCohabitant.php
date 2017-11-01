<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "debtor_cohabitant".
 *
 * @property integer $id
 * @property integer $debtor_id
 * @property integer $name_id
 *
 * @property Debtor $debtor
 * @property Name $name
 */
class DebtorCohabitant extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'debtor_cohabitant';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['debtor_id', 'name_id'], 'integer'],
            [['name_id'], 'unique'],
            [['debtor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Debtor::className(), 'targetAttribute' => ['debtor_id' => 'id']],
            [['name_id'], 'exist', 'skipOnError' => true, 'targetClass' => Name::className(), 'targetAttribute' => ['name_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'debtor_id' => Yii::t('app', 'Должник'),
            'name_id' => Yii::t('app', 'ФИО'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDebtor()
    {
        return $this->hasOne(Debtor::className(), ['id' => 'debtor_id'])->inverseOf('debtorCohabitants');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getName()
    {
        return $this->hasOne(Name::className(), ['id' => 'name_id'])->inverseOf('debtorCohabitant');
    }

    /**
     * @inheritdoc
     * @return DebtorCohabitantQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DebtorCohabitantQuery(get_called_class());
    }
}
