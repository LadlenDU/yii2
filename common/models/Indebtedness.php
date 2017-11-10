<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "indebtedness".
 *
 * @property integer $id
 * @property integer $debtor_id
 * @property string $date
 * @property string $amount
 *
 * @property Debtor $debtor
 */
class Indebtedness extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'indebtedness';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['debtor_id'], 'integer'],
            [['date'], 'safe'],
            [['amount'], 'number'],
            [['debtor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Debtor::className(), 'targetAttribute' => ['debtor_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'debtor_id' => Yii::t('app', 'Debtor ID'),
            'date' => Yii::t('app', 'Дата задолженности'),
            'amount' => Yii::t('app', 'Сумма задолженности'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDebtor()
    {
        return $this->hasOne(Debtor::className(), ['id' => 'debtor_id'])->inverseOf('indebtednesses');
    }
}
