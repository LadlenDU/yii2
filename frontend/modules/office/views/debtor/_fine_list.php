<?php

/* @var $this yii\web\View */
/* @var $dataProvider \yii\data\ArrayDataProvider */
/* @var $debtorId int */

use kartik\grid\GridView;
use yii\helpers\Html;

$gridColumns = [
    [
        'attribute' => 'dateStart',
        'label' => Yii::t('app', 'Начало просрочки'),
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'format' => 'date',
        'xlFormat' => "mmm\\-dd\\, \\-yyyy",
        'headerOptions' => ['class' => 'kv-sticky-column'],
        'contentOptions' => ['class' => 'kv-sticky-column'],
        'filterType' => GridView::FILTER_DATE,
    ],
    [
        'attribute' => 'dateFinish',
        'label' => Yii::t('app', 'Конец просрочки'),
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'format' => 'date',
        'xlFormat' => "mmm\\-dd\\, \\-yyyy",
        'headerOptions' => ['class' => 'kv-sticky-column'],
        'contentOptions' => ['class' => 'kv-sticky-column'],
        'filterType' => GridView::FILTER_DATE,
    ],
    [
        'attribute' => 'fine',
        'label' => Yii::t('app', 'Пеня'),
        'vAlign' => 'middle',
        'hAlign' => 'right',
        'format' => ['decimal', 2],
    ],
    /*[
        'attribute' => 'cost',
        //'label' => Yii::t('app', 'Пеня'),
        'vAlign' => 'middle',
        'hAlign' => 'right',
        'format' => ['decimal', 2],
    ],*/
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
    //'toolbar' => false,
    'panel' => [
        'type' => GridView::TYPE_PRIMARY,
        'heading' => Yii::t('app', 'Пеня'),
    ],
    'bordered' => true,
    'striped' => true,
    'condensed' => true,
    'responsive' => true,
    'hover' => true,
    'toolbar' => [
        ['content' =>
        //Html::button('<i class="glyphicon glyphicon-plus"></i>', ['type'=>'button', 'title'=>Yii::t('kvgrid', 'Add Book'), 'class'=>'btn btn-success', 'onclick'=>'alert("This will launch the book creation form.\n\nDisabled for this demo!");']) . ' '.
            Html::a('<i class="glyphicon glyphicon-print"></i>',
                ['/office/debtor/full-report-fine-data', 'debtor_id' => $debtorId],
                [
                    'data-pjax' => 0,
                    'class' => 'btn btn-default',
                    'title' => Yii::t('app', 'Полный отчет'),
                    'target' => '_blank',
                ]
            )
        ],
        '{export}',
        '{toggleData}',
    ]
]);
