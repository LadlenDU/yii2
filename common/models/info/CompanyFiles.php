<?php

namespace common\models\info;

use Yii;

/**
 * This is the model class for table "company_files".
 *
 * @property integer $id
 * @property string $content
 * @property string $name
 * @property string $mime_type
 *
 * @property CompanyCompanyFiles[] $companyCompanyFiles
 * @property Company[] $companies
 */
class CompanyFiles extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'company_files';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'], 'string'],
            [['name', 'mime_type'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'content' => Yii::t('app', 'Content'),
            'name' => Yii::t('app', 'Name'),
            'mime_type' => Yii::t('app', 'Mime Type'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyCompanyFiles()
    {
        return $this->hasMany(CompanyCompanyFiles::className(), ['company_files_id' => 'id'])->inverseOf('companyFiles');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanies()
    {
        return $this->hasMany(Company::className(), ['id' => 'company_id'])->viaTable('company_company_files', ['company_files_id' => 'id']);
    }
}
