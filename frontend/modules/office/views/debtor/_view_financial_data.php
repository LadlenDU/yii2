<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Debtor */

echo DetailView::widget([
    'model' => $model,
    'attributes' => [
        'expiration_start',
        'debt_total',
    ],
]);
