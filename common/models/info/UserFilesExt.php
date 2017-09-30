<?php

namespace common\models\info;

use yii\web\Response;
use yii\web\NotFoundHttpException;

class UserFilesExt extends UserFiles
{
    public function outputInline($id)
    {
        //TODO: секьюрный косяк???
        //if ($infoModel = UserFiles::find()->where(['user_id' => Yii::$app->user->identity->getId()])->one()) {
        if ($infoModel = $this->findOne($id)) {
            $options['mimeType'] = $infoModel->mime_type;
            $options['inline'] = true;
            (new Response)->sendContentAsFile($infoModel->content, $infoModel->name, $options);
            exit;
        } else {
            throw new NotFoundHttpException();
        }
    }

    public function outputFile($id)
    {
        //TODO: секьюрный косяк???
        if ($infoModel = $this->findOne($id)) {
            $options['mimeType'] = $infoModel->mime_type;
            $options['inline'] = false;
            (new Response)->sendContentAsFile($infoModel->content, $infoModel->name, $options);
            exit;
        } else {
            throw new NotFoundHttpException();
        }
    }
}
