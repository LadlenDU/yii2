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
            [['excelFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xls, xlsx'],
            [['csvFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'csv'],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            //$this->imageFile->saveAs('uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            $fileName = tempnam(Yii::getAlias('@common') . '/uploads/excel', 'exc_');
            #$fileName .= '.' . $this->excelFile->extension;
            $this->excelFile->saveAs($fileName);
            return $fileName;
        }

        return false;
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
                'showRemove' => false,
                'showUpload' => false,
                'allowedFileExtensions' => ($type == 'excel') ? ['xls', 'xlsx'] : ['csv'],
                'initialPreviewAsData' => true,
                //'initialPreviewFileType' => 'xlsx',
                'initialCaption' => Yii::t('app', 'Список должников'),
                'overwriteInitial' => false,
            ],
        ];

        if ($type == 'csv') {
            $options['options']['accept'] = 'text/csv';
        }

        return $options;
    }
}
