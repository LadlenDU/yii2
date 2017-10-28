<?php

/**
 * @var yii\web\View $this
 */

use kartik\grid\GridView;

$this->beginContent('@dektrium/user/views/admin/update.php', ['user' => $user]);

$gridColumns = [
    [
        'attribute' => 'date',
        //'format' => ['decimal', 2],
    ],
    [
        'attribute' => 'price',
        'format' => ['decimal', 2],
    ],
    [
        'attribute' => 'original_balance',
        'format' => ['decimal', 2],
    ],
];

if ($dataProvider) {
    echo GridView::widget([
        'id' => 'accrual-list-grid',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumns,
        'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
        'headerRowOptions' => ['class' => 'kartik-sheet-style'],
        'filterRowOptions' => ['class' => 'kartik-sheet-style'],
        'pjax' => true,
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
} else {
    echo 'Нет информации';
}

$this->endContent();
