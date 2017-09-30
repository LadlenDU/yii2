<?php

namespace common\models\info;

use Yii;
use yii\web\Response;
use yii\web\NotFoundHttpException;

class UserFilesExt extends UserFiles
{
    public static function outputInline($id)
    {
        //TODO: секьюрный косяк???
        //if ($model = UserFiles::find()->where(['user_id' => Yii::$app->user->identity->getId()])->one()) {
        if ($model = self::findOne($id)) {
            $options['mimeType'] = $model->mime_type;
            $options['inline'] = true;
            Yii::$app->getResponse()->sendContentAsFile($model->content, $model->name, $options)->send();
            exit;
        } else {
            //TODO: при ajax - косяк
            throw new NotFoundHttpException();
        }
    }

    public static function outputFile($id)
    {
        //TODO: секьюрный косяк???
        if ($model = self::findOne($id)) {
            $options['mimeType'] = $model->mime_type;
            $options['inline'] = false;
            //(new Response)->sendContentAsFile($model->content, $model->name, $options);
            Yii::$app->getResponse()->sendContentAsFile($model->content, $model->name, $options)->send();
            exit;
        } else {
            //TODO: при ajax - косяк
            throw new NotFoundHttpException();
        }
    }

    public static function remove($id)
    {
        //TODO: секьюрный косяк???
        if ($model = self::findOne($id)) {
            $model->delete();
            exit;
        } else {
            //TODO: при ajax - косяк
            throw new NotFoundHttpException();
        }
    }
}
