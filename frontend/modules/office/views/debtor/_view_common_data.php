<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Debtor */

echo DetailView::widget([
    'model' => $model,
    'attributes' => [
        'name.first_name',
        'name.second_name',
        'name.patronymic',
        'name.full_name',
        'phone',
        'LS_EIRC',
        [
            'label' => '№ личного счета',
            'value' => $model->LS_IKU_provider,
        ],
        'IKU',
        'space_common',
        'space_living',
        [
            'label' => 'Форма собственности',
            'attribute' => 'ownershipType.name',
        ],
        'location.region',
        'location.district',
        'location.city',
        'location.street',
        'location.building',
        'location.appartment',
        'location.zip_code',
        [
            'label' => 'Произвольное написание',
            'attribute' => 'location.arbitraty',        //TODO: переименовать
        ],
    ],
]);


