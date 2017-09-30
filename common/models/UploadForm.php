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
    public $csvFile;

    public function rules()
    {
        return [
            //[['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
            [['excelFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'xls, xlsx'],
            [['csvFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'csv'],
        ];
    }

    public function uploadExcel()
    {
        if ($this->validate()) {
            //if ($this->excelFile) {
            //$this->imageFile->saveAs('uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            $fileName = tempnam(Yii::getAlias('@common') . '/uploads/debtors', 'excel_');
            //$fileName .= '.' . $this->excelFile->extension;
            $this->excelFile->saveAs($fileName);
            return $fileName;
        }

        return false;
    }

    public function uploadCsv()
    {
        if ($this->validate()) {
            $fileName = tempnam(Yii::getAlias('@common') . '/uploads/debtors', 'csv_');
            //$fileName .= '.' . $this->csvFile->extension;
            $this->csvFile->saveAs($fileName);
            return $fileName;
        }

        return false;
    }

    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        $labels['excelFile'] = Yii::t('app', 'Файл Excel');
        $labels['csvFile'] = Yii::t('app', 'Файл СSV');

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
