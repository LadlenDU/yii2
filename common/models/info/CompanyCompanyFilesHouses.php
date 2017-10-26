<?php

namespace common\models\info;

use Yii;

/**
 * This is the model class for table "company_company_files_houses".
 *
 * @property integer $company_id
 * @property integer $company_files_houses_id
 *
 * @property CompanyFilesHouses $companyFilesHouses
 * @property Company $company
 */
class CompanyCompanyFilesHouses extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'company_company_files_houses';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'company_files_houses_id'], 'required'],
            [['company_id', 'company_files_houses_id'], 'integer'],
            [['company_files_houses_id'], 'exist', 'skipOnError' => true, 'targetClass' => CompanyFilesHouses::className(), 'targetAttribute' => ['company_files_houses_id' => 'id']],
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
            'company_files_houses_id' => Yii::t('app', 'Company Files Houses ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyFilesHouses()
    {
        return $this->hasOne(CompanyFilesHouses::className(), ['id' => 'company_files_houses_id'])->inverseOf('companyCompanyFilesHouses');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id'])->inverseOf('companyCompanyFilesHouses');
    }
}
