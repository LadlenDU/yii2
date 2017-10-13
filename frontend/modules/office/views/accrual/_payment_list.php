<?php

/* @var $this yii\web\View */
/* @var $model common\models\Debtor */
/* @var $debtor_id int */

//use yii\widgets\ListView;
use kartik\grid\GridView;
use yii\helpers\Html;

$gridColumns = [
    [
        'attribute' => 'payment_date',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'format' => 'date',
        'xlFormat' => "mmm\\-dd\\, \\-yyyy",
        'headerOptions' => ['class' => 'kv-sticky-column'],
        'contentOptions' => ['class' => 'kv-sticky-column'],
        'filterType' => GridView::FILTER_DATE,
    ],
    [
        'attribute' => 'amount',
        'vAlign' => 'middle',
        'hAlign' => 'right',
        'format' => ['decimal', 2],
    ],
];

echo GridView::widget([
    'id' => 'accrual-list-grid',
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => $gridColumns,
    'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
    'headerRowOptions' => ['class' => 'kartik-sheet-style'],
    'filterRowOptions' => ['class' => 'kartik-sheet-style'],
    'pjax' => true,
    'toolbar' => [
        [
            'content' =>
                Html::a('<i class="glyphicon glyphicon-plus"></i>',
                    ['/office/accrual/create', 'debtor_id' => $debtor_id],
                    [
                        'data-pjax' => 0,
                        'class' => 'btn btn-default',
                        'title' => Yii::t('app', 'Добавить начисление'),
                        'target' => '_blank',
                    ]
                )
        ],
    ],
    'panel' => [
        'type' => GridView::TYPE_PRIMARY,
        'heading' => Yii::t('app', 'Начислено'),
    ],
    'bordered' => true,
    'striped' => true,
    'condensed' => true,
    'responsive' => true,
    'hover' => true,
]);
