<?php

/* @var $this yii\web\View */
/* @var $model common\models\info\Company */

use kartik\detail\DetailView;

$attributes = [

    'full_name',
    'short_name',
    //'legal_address_location_id',
    //'actual_address_location_id',
    'INN',
    'KPP',
    'BIK',
    'OGRN',
    'checking_account',
    'correspondent_account',
    'full_bank_name',
    'CEO',
    'operates_on_the_basis_of',
    'phone',
    'fax',
    'email:email',
];

echo DetailView::widget([
    'model' => $model,
    'attributes' => $attributes,
    'mode' => 'view',
    'bordered' => true,
    'striped' => true,
    'condensed' => true,
    'responsive' => true,
    'hover' => true,
    'hAlign' => 'right',
    'vAlign' => 'middle',
    'container' => ['id' => 'company-common-data'],
]);
