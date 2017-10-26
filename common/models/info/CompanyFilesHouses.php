<?php

namespace common\models\info;

use Yii;

/**
 * This is the model class for table "company_files_houses".
 *
 * @property integer $id
 * @property string $content
 * @property string $name
 * @property string $mime_type
 *
 * @property CompanyCompanyFilesHouses[] $companyCompanyFilesHouses
 * @property Company[] $companies
 */
class CompanyFilesHouses extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'company_files_houses';
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
    public function getCompanyCompanyFilesHouses()
    {
        return $this->hasMany(CompanyCompanyFilesHouses::className(), ['company_files_houses_id' => 'id'])->inverseOf('companyFilesHouses');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanies()
    {
        return $this->hasMany(Company::className(), ['id' => 'company_id'])->viaTable('company_company_files_houses', ['company_files_houses_id' => 'id']);
    }
}
