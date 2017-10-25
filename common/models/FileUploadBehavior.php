<?php

namespace common\models;

use Yii;
use yii\base\Behavior;
//use yii\web\NotFoundHttpException;

class FileUploadBehavior extends Behavior
{
    public function outputInline()
    {
        //TODO: секьюрный косяк???
        //if ($model = UserFiles::find()->where(['user_id' => Yii::$app->user->identity->getId()])->one()) {
        #if ($model = self::findOne($id)) {
            $options['mimeType'] = $this->owner->mime_type;
            $options['inline'] = true;
            Yii::$app->getResponse()->sendContentAsFile($this->owner->content, $this->owner->name, $options)->send();
            exit;
        #} else {
        #    //TODO: при ajax - косяк
        #    throw new NotFoundHttpException();
        #}
    }

    public function outputFile()
    {
        //TODO: секьюрный косяк???
        #if ($model = self::findOne($id)) {
            $options['mimeType'] = $this->owner->mime_type;
            $options['inline'] = false;
            //(new Response)->sendContentAsFile($model->content, $model->name, $options);
            Yii::$app->getResponse()->sendContentAsFile($this->owner->content, $this->owner->name, $options)->send();
            exit;
        #} else {
        #    //TODO: при ajax - косяк
        #    throw new NotFoundHttpException();
        #}
    }

    public function remove()
    {
        //TODO: секьюрный косяк???
        #if ($model = self::findOne($id)) {
            //TODO: обработка ошибок удаления
            $this->owner->delete();
            echo json_encode([]);
            exit;
        #} else {
        #    //TODO: при ajax - косяк
        #    throw new NotFoundHttpException();
        #}
    }
}
