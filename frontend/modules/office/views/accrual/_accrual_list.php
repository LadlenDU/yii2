<?php

/* @var $this yii\web\View */
/* @var $model common\models\Debtor */

//use yii\widgets\ListView;
use kartik\grid\GridView;
use yii\helpers\Html;

$gridColumns = [
    ['attribute' => 'accrual_date'],
    ['attribute' => 'accrual'],
    ['attribute' => 'single'],
    ['attribute' => 'additional_adjustment'],
    ['attribute' => 'subsidies'],
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
                Html::button('<i class="glyphicon glyphicon-plus"></i>',
                    [
                        'type' => 'button',
                        'title' => Yii::t('app', 'Добавить начисление'),
                        'class' => 'btn btn-success',
                    ]
                )
        ],
        //'{export}',
        //'{toggleData}',
    ],
    'panel' => [
        'type' => GridView::TYPE_PRIMARY,
        //'heading' => $heading,
    ],
    'bordered' => true,
    'striped' => true,
    'condensed' => true,
    'responsive' => true,
    'hover' => true,
    // set your toolbar
    /*'toolbar' => [
        ['content' =>
            Html::button('<i class="glyphicon glyphicon-plus"></i>', ['type' => 'button', 'title' => Yii::t('kvgrid', 'Add Book'), 'class' => 'btn btn-success', 'onclick' => 'alert("This will launch the book creation form.\n\nDisabled for this demo!");']) . ' ' .
            Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['grid-demo'], ['data-pjax' => 0, 'class' => 'btn btn-default', 'title' => Yii::t('kvgrid', 'Reset Grid')])
        ],
        '{export}',
        '{toggleData}',
    ],
    // set export properties
    'export' => [
        'fontAwesome' => true
    ],
    // parameters from the demo form
    'bordered' => $bordered,
    'striped' => $striped,
    'condensed' => $condensed,
    'responsive' => $responsive,
    'hover' => $hover,
    'showPageSummary' => $pageSummary,
    'panel' => [
        'type' => GridView::TYPE_PRIMARY,
        'heading' => $heading,
    ],
    'persistResize' => false,
    'toggleDataOptions' => ['minCount' => 10]
    'exportConfig'=>$exportConfig,*/
]);
