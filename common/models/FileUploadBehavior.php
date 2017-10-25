<?php

namespace common\models;

use Yii;
use yii\base\Behavior;
use yii\helpers\Url;

//use yii\web\NotFoundHttpException;

class FileUploadBehavior extends Behavior
{
    public function outputInline()
    {
        $options['mimeType'] = $this->owner->mime_type;
        $options['inline'] = true;
        Yii::$app->getResponse()->sendContentAsFile($this->owner->content, $this->owner->name, $options)->send();
        exit;
    }

    public function outputFile()
    {
        $options['mimeType'] = $this->owner->mime_type;
        $options['inline'] = false;
        //(new Response)->sendContentAsFile($model->content, $model->name, $options);
        Yii::$app->getResponse()->sendContentAsFile($this->owner->content, $this->owner->name, $options)->send();
        exit;
    }

    public function remove()
    {
        //TODO: обработка ошибок удаления
        $this->owner->delete();
        echo json_encode([]);
        exit;
    }
}
