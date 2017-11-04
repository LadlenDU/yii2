<?php

namespace common\models\debtor_status;

use Yii;

/**
 * This is the model class for table "debtor_status_files".
 *
 * @property integer $id
 * @property integer $debtor_id
 * @property string $content
 * @property string $name
 * @property string $mime_type
 *
 * @property Debtor $debtor
 */
class DebtorStatusFiles extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'debtor_status_files';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['debtor_id'], 'required'],
            [['debtor_id'], 'integer'],
            [['content'], 'string'],
            [['name', 'mime_type'], 'string', 'max' => 255],
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
            'debtor_id' => Yii::t('app', 'ID должника, которому принадлежит файл'),
            'content' => Yii::t('app', 'Content'),
            'name' => Yii::t('app', 'Name'),
            'mime_type' => Yii::t('app', 'Mime Type'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDebtor()
    {
        return $this->hasOne(Debtor::className(), ['id' => 'debtor_id'])->inverseOf('debtorStatusFiles');
    }
}
