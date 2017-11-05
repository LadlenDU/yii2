<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "debtor_status_files".
 *
 * @property integer $id
 * @property integer $debtor_status_id
 * @property string $content
 * @property string $name
 * @property string $mime_type
 *
 * @property DebtorStatus $debtorStatus
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
            [['debtor_status_id'], 'required'],
            [['debtor_status_id'], 'integer'],
            [['content'], 'string'],
            [['name', 'mime_type'], 'string', 'max' => 255],
            [['debtor_status_id'], 'exist', 'skipOnError' => true, 'targetClass' => DebtorStatus::className(), 'targetAttribute' => ['debtor_status_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'debtor_status_id' => Yii::t('app', 'ID статуса должника, которому принадлежит файл'),
            'content' => Yii::t('app', 'Content'),
            'name' => Yii::t('app', 'Name'),
            'mime_type' => Yii::t('app', 'Mime Type'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDebtorStatus()
    {
        return $this->hasOne(DebtorStatus::className(), ['id' => 'debtor_status_id'])->inverseOf('debtorStatusFiles');
    }
}
