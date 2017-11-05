<?php

namespace common\helpers;

use Yii;
use yii\helpers\Html;

class HtmlHelper
{
    public static function getCenteredAjaxLoadImg()
    {
        return '<div style="text-align:center">'
            . Html::img('/img/ajax-loader.gif', ['alt' => Yii::t('app', 'Загрузка...')])
            . '</div>';
    }
}
