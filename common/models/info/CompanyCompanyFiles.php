<?php

namespace common\models\info;

use Yii;

/**
 * This is the model class for table "company_company_files".
 *
 * @property integer $company_id
 * @property integer $company_files_id
 *
 * @property CompanyFiles $companyFiles
 * @property Company $company
 */
class CompanyCompanyFiles extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'company_company_files';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'company_files_id'], 'required'],
            [['company_id', 'company_files_id'], 'integer'],
            [['company_files_id'], 'exist', 'skipOnError' => true, 'targetClass' => CompanyFiles::className(), 'targetAttribute' => ['company_files_id' => 'id']],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'company_id' => Yii::t('app', 'Company ID'),
            'company_files_id' => Yii::t('app', 'Company Files ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyFiles()
    {
        return $this->hasOne(CompanyFiles::className(), ['id' => 'company_files_id'])->inverseOf('companyCompanyFiles');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id'])->inverseOf('companyCompanyFiles');
    }
}
