<?php

use yii\helpers\Html;
//use yii\widgets\DetailView;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Debtor */

$modelName = $model->name ?: (new common\models\Name);
$modelLocation = $model->location ?: (new common\models\Location);
$modelOwnership = $model->ownershipType ?: (new common\models\OwnershipType);

$fm = Yii::$app->formatter;

$attributes = [
    [
        'group' => true,
        'label' => Yii::t('app', 'ФИО'),
        'rowOptions' => ['class' => 'info']
    ],
    [
        'columns' => [
            [
                'attribute' => 'name_id',
                'label' => $modelName->getAttributeLabel('second_name'),
                'value' => $fm->asText($modelName->second_name),
                'labelColOptions' => ['style' => 'width:10.3%;text-align:right'],
                'valueColOptions' => ['style' => 'width:23%'],
                //'displayOnly' => true,
                'format' => 'raw',
            ],
            [
                'attribute' => 'name_id',
                'label' => $modelName->getAttributeLabel('first_name'),
                'value' => $fm->asText($modelName->first_name),
                'labelColOptions' => ['style' => 'width:10.3%;text-align:right'],
                'valueColOptions' => ['style' => 'width:23%'],
                //'displayOnly' => true,
                'format' => 'raw',
            ],
            [
                'attribute' => 'name_id',
                'label' => $modelName->getAttributeLabel('patronymic'),
                'value' => $fm->asText($modelName->patronymic),
                'labelColOptions' => ['style' => 'width:10.3%;text-align:right'],
                'valueColOptions' => ['style' => 'width:23%'],
                'displayOnly' => true,
                'format' => 'raw',
            ],
        ],
    ],
    /*[
        'columns' => [
            [
                'attribute' => 'name_id',
                'label' => Yii::t('app', 'Имя полностью'),
                'value' => $fm->asText($modelName->full_name),
                'displayOnly' => true,
                'format' => 'raw',
            ],
        ],
        'rowOptions' => ['class' => 'warning', 'style' => 'border-top: 5px double #dedede'],
    ],*/
    [
        'group' => true,
        'label' => Yii::t('app', 'Адрес'),
        'rowOptions' => ['class' => 'info']
    ],
    /*[
        'columns' => [
            [
                'attribute' => 'location_id',
                'label' => $modelLocation->getAttributeLabel('zip_code'),
                'value' => $modelLocation->zip_code,
                'labelColOptions' => ['style' => 'width:10.3%;text-align:right'],
                'valueColOptions' => ['style' => 'width:23%'],
                'displayOnly' => true,
                'format' => 'raw',
            ],
            [
                'attribute' => 'location_id',
                'label' => $modelLocation->getAttributeLabel('region'),
                'value' => $fm->asText($modelLocation->region) . ' (id: <kbd>' . $fm->asText($modelLocation->regionId) . '</kbd>)',
                'labelColOptions' => ['style' => 'width:10.3%;text-align:right'],
                'valueColOptions' => ['style' => 'width:23%'],
                'displayOnly' => true,
                'format' => 'raw',
            ],
            [
                'attribute' => 'location_id',
                'label' => $modelLocation->getAttributeLabel('city'),
                'value' => $fm->asText($modelLocation->city) . ' (id: <kbd>' . $fm->asText($modelLocation->cityId) . '</kbd>)',
                'labelColOptions' => ['style' => 'width:10.3%;text-align:right'],
                'valueColOptions' => ['style' => 'width:23%'],
                'displayOnly' => true,
                'format' => 'raw',
            ],
        ],
    ],
    [
        'columns' => [
            [
                'attribute' => 'location_id',
                'label' => $modelLocation->getAttributeLabel('street'),
                'value' => $fm->asText($modelLocation->street) . ' (id: <kbd>' . $fm->asText($modelLocation->streetId) . '</kbd>)',
                'labelColOptions' => ['style' => 'width:10.3%;text-align:right'],
                'valueColOptions' => ['style' => 'width:23%'],
                'displayOnly' => true,
                'format' => 'raw',
            ],
            [
                'attribute' => 'location_id',
                'label' => $modelLocation->getAttributeLabel('building'),
                'value' => $fm->asText($modelLocation->building) . ' (id: <kbd>' . $fm->asText($modelLocation->buildingId) . '</kbd>)',
                'labelColOptions' => ['style' => 'width:10.3%;text-align:right'],
                'valueColOptions' => ['style' => 'width:23%'],
                'displayOnly' => true,
                'format' => 'raw',
            ],
            [
                'attribute' => 'location_id',
                'label' => $modelLocation->getAttributeLabel('appartment'),
                'value' => $fm->asText($modelLocation->appartment),
                'labelColOptions' => ['style' => 'width:10.3%;text-align:right'],
                'valueColOptions' => ['style' => 'width:23%'],
                'displayOnly' => true,
                'format' => 'raw',
            ],
        ],
    ],*/
    [
        'columns' => [
            [
                'attribute' => 'location_id',
                'label' => Yii::t('app', 'Полный адрес'),
                'value' => $fm->asText($modelLocation->full_address),
                'displayOnly' => true,
                'format' => 'raw',
            ],
        ],
        //'rowOptions' => ['class' => 'warning', 'style' => 'border-top: 5px double #dedede'],
    ],
    [
        'group' => true,
        'label' => Yii::t('app', 'Данные'),
        'rowOptions' => ['class' => 'info']
    ],
    [
        'columns' => [
            [
                'attribute' => 'LS_EIRC',
                'value' => '<kbd>' . $fm->asText($model->LS_EIRC) . '</kbd>',
                'labelColOptions' => ['style' => 'width:20%;text-align:right'],
                'valueColOptions' => ['style' => 'width:30%'],
                'displayOnly' => true,
                'format' => 'raw',
            ],
            /*[
                'attribute' => 'LS_IKU_provider',
                'value' => '<kbd>' . $fm->asText($model->LS_IKU_provider) . '</kbd>',
                'labelColOptions' => ['style' => 'width:10.3%;text-align:right'],
                'valueColOptions' => ['style' => 'width:23%'],
                'displayOnly' => true,
                'format' => 'raw',
            ],*/
            [
                'attribute' => 'IKU',
                'value' => '<kbd>' . $fm->asText($model->IKU) . '</kbd>',
                'labelColOptions' => ['style' => 'width:20%;text-align:right'],
                'valueColOptions' => ['style' => 'width:30%'],
                'displayOnly' => true,
                'format' => 'raw',
            ],
        ],
    ],
    [
        'columns' => [
            [
                'attribute' => 'phone',
                'labelColOptions' => ['style' => 'width:10.3%;text-align:right'],
                'valueColOptions' => ['style' => 'width:23%'],
                'displayOnly' => true,
            ],
            [
                'attribute' => 'space_common',
                'labelColOptions' => ['style' => 'width:10.3%;text-align:right'],
                'valueColOptions' => ['style' => 'width:23%'],
                'displayOnly' => true,
            ],
            /*[
                'attribute' => 'space_living',
                'labelColOptions' => ['style' => 'width:10.3%;text-align:right'],
                'valueColOptions' => ['style' => 'width:23%'],
                'displayOnly' => true,
            ],*/
            [
                'attribute' => 'ownership_type_id',
                'value' => $fm->asText($modelOwnership->name),
                'labelColOptions' => ['style' => 'width:10.3%;text-align:right'],
                'valueColOptions' => ['style' => 'width:23%'],
                'displayOnly' => true,
                'format' => 'raw',
            ],
        ],
    ],
];

echo DetailView::widget([
    'model' => $model,
    //'condensed' => true,
    'hover' => true,
    'bordered' => true,
    'striped' => false,
    'hAlign' => 'right',
    'responsive' => true,
    'mode' => DetailView::MODE_VIEW,
    //'mode' => DetailView::MODE_EDIT,
    'panel' => [
        'heading'=>'&nbsp;',
        'type' => DetailView::TYPE_INFO,
    ],
    /*'deleteOptions'=>[ // your ajax delete parameters
        'params' => ['id' => 1000, 'kvdelete'=>true],
    ],
    'container' => ['id'=>'kv-demo'],
    'formOptions' => ['action' => yii\helpers\Url::current(['#' => 'kv-demo'])], // your action to delete*/
    'attributes' => $attributes,/*[
        [
            'label' => $model->name->getAttribute('first_name'),
            'value' => $model->name->first_name,
        ],
        //'name.first_name',
//        'name.second_name',
//        'name.patronymic',
//        'name.full_name',
        'phone',
        'LS_EIRC',
        [
            'label' => '№ личного счета',
            'value' => $model->LS_IKU_provider,
        ],
        'IKU',
        'space_common',
        'space_living',
//        [
//            'label' => 'Форма собственности',
//            'attribute' => 'ownershipType.name',
//        ],
//        'location.region',
//        'location.district',
//        'location.city',
//        'location.street',
//        'location.building',
//        'location.appartment',
//        'location.zip_code',
//        [
//            'label' => 'Произвольное написание',
//            'attribute' => 'location.full_address',
//        ],
    ],*/
]);


