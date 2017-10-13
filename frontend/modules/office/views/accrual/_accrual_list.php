<?php

/* @var $this yii\web\View */
/* @var $model common\models\Debtor */
/* @var $debtor_id int */

//use yii\widgets\ListView;
use kartik\grid\GridView;
use yii\helpers\Html;

$gridColumns = [
    [
        //'class'=>'kartik\grid\EditableColumn',
        'attribute' => 'accrual_date',
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'format' => 'date',
        'xlFormat' => "mmm\\-dd\\, \\-yyyy",
        'headerOptions' => ['class' => 'kv-sticky-column'],
        'contentOptions' => ['class' => 'kv-sticky-column'],
        //'filterType' => GridView::INPUT_DATE,
        'filterType' => GridView::FILTER_DATE,
        /*'editableOptions' => [
            //'header' => 'Publish Date',
            'size' => 'md',
            'inputType' => \kartik\editable\Editable::INPUT_WIDGET,
            'widgetClass' => 'kartik\datecontrol\DateControl',
            'options' => [
                'type' => \kartik\datecontrol\DateControl::FORMAT_DATE,
                'displayFormat' => 'dd.MM.yyyy',
                'saveFormat' => 'php:Y-m-d',
                'options' => [
                    'pluginOptions' => [
                        'autoclose' => true
                    ]
                ]
            ]
        ],*/
    ],
    [
        'attribute' => 'accrual',
        'vAlign' => 'middle',
        'hAlign' => 'right',
        'format' => ['decimal', 2],
    ],
    [
        'attribute' => 'single',
        'vAlign' => 'middle',
        'hAlign' => 'right',
        'format' => ['decimal', 2],
    ],
    [
        'attribute' => 'additional_adjustment',
        'vAlign' => 'middle',
        'hAlign' => 'right',
        'format' => ['decimal', 2],
    ],
    [
        'attribute' => 'subsidies',
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
            /*Html::a('<i class="glyphicon glyphicon-plus"></i>',
                [
                    'type' => 'button',
                    'title' => Yii::t('app', 'Добавить начисление'),
                    'class' => 'btn btn-success',
                ]
            )*/
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
        //'{export}',
        //'{toggleData}',
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
