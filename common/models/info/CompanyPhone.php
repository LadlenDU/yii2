<?php

namespace common\models\info;

use Yii;

/**
 * This is the model class for table "company_phone".
 *
 * @property integer $id
 * @property integer $company_id
 * @property string $phone
 *
 * @property Company $company
 */
class CompanyPhone extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'company_phone';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'phone'], 'required'],
            [['company_id'], 'integer'],
            [['phone'], 'string', 'max' => 255],
            [['company_id', 'phone'], 'unique', 'targetAttribute' => ['company_id', 'phone'], 'message' => 'The combination of Company ID and Phone has already been taken.'],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'company_id' => Yii::t('app', 'Company ID'),
            'phone' => Yii::t('app', 'Phone'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id'])->inverseOf('companyPhones');
    }
}
