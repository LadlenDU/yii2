<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    #public $imageFile;
    public $excelFile;

    public function rules()
    {
        return [
            //[['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
            [['excelFile'], 'file', 'skipOnEmpty' => false, 'extensions' => '.xls, xlsx'],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            //$this->imageFile->saveAs('uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            $fileName = tempnam(Yii::getAlias('@common') . '/uploads/excel', 'exc_');
            #$fileName .= '.' . $this->excelFile->extension;
            $this->excelFile->saveAs($fileName);
            return true;
        } else {
            return false;
        }
    }
}
