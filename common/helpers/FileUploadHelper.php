<?php

namespace common\helpers;

use Yii;
use yii\helpers\Url;

class FileUploadHelper
{
    /** @var string просто подсказка */
    //public $fileUploadLink = '/office/user-file';
    public $fileUploadLink;
    public $uploadOptions;

    public function __construct($fileUploadLink, $uploadOptions = [])
    {
        $this->fileUploadLink = $fileUploadLink;
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

        $this->uploadOptions = array_replace_recursive($this->uploadOptions, $uploadOptions);
    }

    public function fileUploadConfig($files)
    {
        $filesPluginOptions = [
            'initialPreview' => [],
            'initialPreviewConfig' => [],
        ];

        if ($files) {
            foreach ($files as $key => $file) {
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
        }

        $options = [
            'pluginOptions' => [
                'initialPreview' => $filesPluginOptions['initialPreview'],
                'initialPreviewConfig' => $filesPluginOptions['initialPreviewConfig'],
            ],
        ];

        $options = array_replace_recursive($this->uploadOptions, $options);

        return $options;
    }
}
