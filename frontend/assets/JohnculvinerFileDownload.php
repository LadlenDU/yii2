<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class JohnculvinerFileDownload extends AssetBundle
{
    public $sourcePath = '@bower/jquery-file-download/src/Scripts/';
    public $js = [
        'jquery.fileDownload.js',
    ];
    public $depends = [
        'frontend\assets\AppAsset',
    ];
}
