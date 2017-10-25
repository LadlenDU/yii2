<?php

namespace common\models;

use Yii;
use yii\base\Behavior;
use yii\helpers\Url;

//use yii\web\NotFoundHttpException;

class FileUploadBehavior extends Behavior
{
    /** @var string просто подсказка */
    public $fileUploadLink = '/office/user-file';
    public $uploadOptions;

    public function __construct($config)
    {
        $this->uploadOptions = [
            'options' => [
                'accept' => 'application/pdf',
                'multiple' => true,
            ],
            'pluginOptions' => [
                'showRemove' => false,
                'initialPreview' => [],
                'initialPreviewAsData' => true,
                'initialPreviewFileType' => 'pdf',
                'initialCaption' => Yii::t('app', 'Дополнительные файлы'),
                'initialPreviewConfig' => [],
                'overwriteInitial' => false,
            ],
            'pluginEvents' => [
                'filebeforedelete' =>
                    'function() {
                        var aborted = !window.confirm(' . json_encode(Yii::t('app', 'Вы уверены что хотите удалить элемент?')) . ');
                        return aborted;
                    }',
            ],
        ];

        parent::__construct($config);
    }

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

    public function fileUploadConfig($filesModel)
    {
        $filesPluginOptions = [
            'initialPreview' => [],
            'initialPreviewConfig' => [],
        ];

        foreach ($filesModel as $key => $file) {
            //TODO: проверить (реализовать) секьюрность (чтобы чужие файлы не открывались)
            //$this->fileUploadLink == '/office/user-file';
            $filesPluginOptions['initialPreview'][] = Url::to([$this->fileUploadLink, 'id' => $file->id]);
            $filesPluginOptions['initialPreviewConfig'][] = [
                'key' => $key,
                'filetype' => $file->mime_type,
                'caption' => $file->name,
                'size' => strlen($file->content),
                'url' => Url::to([$this->fileUploadLink, 'id' => $file->id, 'action' => 'remove']),
                'downloadUrl' => Url::to([$this->fileUploadLink, 'id' => $file->id, 'action' => 'download']),
            ];
        }

        $options = [
            'pluginOptions' => [
                'initialPreview' => $filesPluginOptions['initialPreview'],
                'initialPreviewConfig' => $filesPluginOptions['initialPreviewConfig'],
            ],
        ];

        $options = array_merge_recursive($this->uploadOptions, $options);

        return $options;
    }
}
