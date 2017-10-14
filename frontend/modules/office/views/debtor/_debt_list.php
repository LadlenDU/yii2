<?php

/* @var $this yii\web\View */
/* @var $dataProvider \yii\data\ArrayDataProvider */

use kartik\grid\GridView;

$gridColumns = [
    [
        'attribute' => 'date',
        'label' => Yii::t('app', 'Дата'),
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'format' => 'date',
        'xlFormat' => "mmm\\-dd\\, \\-yyyy",
        'headerOptions' => ['class' => 'kv-sticky-column'],
        'contentOptions' => ['class' => 'kv-sticky-column'],
        'filterType' => GridView::FILTER_DATE,
    ],
    [
        'attribute' => 'debt',
        'label' => Yii::t('app', 'Задолженность'),
        'vAlign' => 'middle',
        'hAlign' => 'right',
        'format' => ['decimal', 2],
    ],
];

echo GridView::widget([
    'id' => 'payment-list-grid',
    'dataProvider' => $dataProvider,
    //'filterModel' => $searchModel,
    'columns' => $gridColumns,
    'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
    'headerRowOptions' => ['class' => 'kartik-sheet-style'],
    'filterRowOptions' => ['class' => 'kartik-sheet-style'],
    'pjax' => true,
    'toolbar' => false,
    'panel' => [
        'type' => GridView::TYPE_PRIMARY,
        'heading' => Yii::t('app', 'Задолженность'),
    ],
    'bordered' => true,
    'striped' => true,
    'condensed' => true,
    'responsive' => true,
    'hover' => true,
]);
