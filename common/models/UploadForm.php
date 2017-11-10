<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use yii\helpers\Url;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    #public $imageFile;
    public $excelFile;
    public $excelFileForAUser;
    public $csvFile;
    public $excelFileType1;

    public function rules()
    {
        return [
            //[['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
            [['excelFileForAUser', 'excelFile', 'excelFileType1'], 'file', 'skipOnEmpty' => true, 'extensions' => 'xls, xlsx'],
            [['csvFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'csv'],
        ];
    }

    public function uploadExcel($type = 'excelFile')
    {
        if ($this->validate()) {
            //if ($this->excelFile) {
            //$this->imageFile->saveAs('uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            $fileName = @tempnam(Yii::getAlias('@common') . '/uploads/debtors', $type . '_');
            //$fileName .= '.' . $this->excelFile->extension;
            $this->$type->saveAs($fileName);
            return $fileName;
        }

        return false;
    }

    public function uploadCsv()
    {
        //TODO: косяк, костыль - исправить
        //if ($this->validate()) {
        if (1) {
            $fileName = @tempnam(Yii::getAlias('@common') . '/uploads/debtors', 'csv_');
            //$fileName .= '.' . $this->csvFile->extension;
            $this->csvFile->saveAs($fileName);
            //TODO: жесткий косяк - ПЕРЕДЕЛАТЬ!!!
            $fContent = file_get_contents($fileName);
            $fContent = mb_convert_encoding($fContent, 'UTF-8', 'CP1251');
            file_put_contents($fileName, $fContent);
            return $fileName;
        }

        return false;
    }

    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        $labels['excelFile'] = Yii::t('app', 'Файл Excel (много пользователей)');
        $labels['excelFileType1'] = Yii::t('app', 'Файл Excel (много пользователей, тип 1)');
        $labels['excelFileForAUser'] = Yii::t('app', 'Файл Excel (один пользователь)');
        $labels['csvFile'] = Yii::t('app', 'Файл СSV (много пользователей)');

        return $labels;
    }

    public function fileUploadConfig($type)
    {
        $options = [
            'options' => [
                //'accept' => 'application/pdf',
                //'accept' => ['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'],
                //'accept' => 'application/vnd.ms-excel',
                //'accept' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'multiple' => false,
            ],
            'pluginOptions' => [
                'showPreview' => false,
                'showRemove' => false,
                'showUpload' => true,
                //'allowedFileExtensions' => ($type == 'excel') ? ['xls', 'xlsx'] : ['csv'],
                //'initialPreviewAsData' => true,
                //'initialPreviewFileType' => 'xlsx',
                'initialCaption' => Yii::t('app', 'Список должников'),
                //'overwriteInitial' => false,
            ],
        ];

        if ($type == 'csv') {
            $options['options']['accept'] = 'text/csv';
        }

        return $options;
    }
}
