<?php
/* @var $this yii\web\View */
/* @var $searchModel common\models\DebtorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $uploadModel common\models\UploadForm */
/* @var $applicationPackage array */
/* @var $functionType string тип отображения (полный - null, 'funct_1' для поиска без некоторого функционала) */

use yii\helpers\Html;
use kartik\dynagrid\DynaGrid;
use common\models\Debtor;
use common\models\DebtorStatus;

if (empty($functionType)) {
    $functionType = '';
}

$columns = [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'order' => DynaGrid::ORDER_FIX_LEFT,
        'checkboxOptions' => [
            'class' => 'sgkh-debtor-check',
        ],
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'buttons' => [
            'view' => function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-list-alt"></span>', $url, ['class' => 'view', 'data-pjax' => '0']);
            },
            'update' => function ($url, $model) {
                return '';
                //return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, ['class' => 'view', 'data-pjax' => '0']);
            },
            'delete' => function ($url, $model) {
                return '';
                //return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, ['class' => 'view', 'data-pjax' => '0']);
            },
        ],
        'order' => DynaGrid::ORDER_FIX_LEFT,
    ],
    [
        'attribute' => 'LS_IKU_provider',
        'pageSummary' => Yii::t('app', 'Итого:'),
        'order' => DynaGrid::ORDER_FIX_LEFT,
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'name.full_name',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'location.city',
        'value' => function (Debtor $model, $key, $index) {
            return $model->getLocationCity();
        },
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'location.address',
        'value' => function (Debtor $model, $key, $index) {
            return isset($model->location) ? $model->location->createFullAddress(['street', 'building', 'appartment']) : '';
        },
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'status',
        'label' => Yii::t('app', 'Статус'),
        'value' => function (Debtor $model, $key, $index) {
            return '<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#statusesModal" data-debtor-id="' . $key . '">'
                . DebtorStatus::getStatusByDebtor($model, true) . '</button>';
        },
        'format' => 'raw',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'accrualSum',
        'hAlign' => 'right',
        /*'pageSummary' => function () {
            return Debtor::find()->sum('debt');
        },*/
    ],
    [
        'attribute' => 'paymentSum',
        'hAlign' => 'right',
    ],
    [
        //'attribute' => 'debtTotal',
        'attribute' => 'debt',
        'hAlign' => 'right',
        'format' => ['decimal', 2],
        'pageSummary' => function () {
            return Debtor::find()->sum('debt');
        },
    ],
    [
        //'attribute' => 'fineTotal',
        'attribute' => 'fine',
        'hAlign' => 'right',
        'format' => ['decimal', 2],
        'pageSummary' => function () {
            return Debtor::find()->sum('fine');
        },
    ],
    [
        //'attribute' => Yii::t('app', 'Пошлина'),
        'attribute' => 'state_fee',
        /*'value' => function (Debtor $model, $key, $index) {
            return $model->calculateStateFee2();
        },*/
        'format' => ['decimal', 2],
        'hAlign' => 'right',
        'pageSummary' => function () {
            return Debtor::find()->sum('state_fee');
        },
    ],
];

$reportHandleButtons = '';

if ($functionType != 'funct_1') {
    if ($applicationPackage['id']) {
        $reportHandleButtons = '<span style="margin-left:1em">'
            . Html::button('<i class="glyphicon glyphicon-minus"></i>',
                [
                    'type' => 'button',
                    'title' => Yii::t('app', 'Удалить выбранных должников из приложения'),
                    'class' => 'btn btn-danger',
                    'id' => 'remove_debtors_from_report',
                ]

            )
            . Html::button('<i class="glyphicon glyphicon-plus"></i>',
                [
                    'type' => 'button',
                    'title' => Yii::t('app', 'Добавить должников в приложение'),
                    'class' => 'btn btn-primary',
                    'id' => 'add_debtors_to_report',
                    'style' => 'margin-left:.4em',
                ]

            )
            . '<span style="margin-left:1em;font-weight:bold">'
            . Yii::t('app', 'Приложение № ' . $applicationPackage['number'])
            . '</span><input type="hidden" id="sgkh-number-of-selected-app" value="' . $applicationPackage['number'] . '"></span>';
    }
}

echo DynaGrid::widget([
    'columns' => $columns,
    'storage' => DynaGrid::TYPE_COOKIE,
    'theme' => 'simple-striped',
    'toggleButtonGrid' => [
        'label' => '<span class="glyphicon glyphicon-cog"></span>',
    ],
    'gridOptions' => [
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'showPageSummary' => true,
        'pjax' => true,
        'panel' => [
            'heading' => '<h3 class="panel-title">' . Yii::t('app', 'Список должников') . '</h3>',
            'before' => '{dynagrid}' . $reportHandleButtons . '<span id="dynagrid-debtors-selected-debtors"><span id="dynagrid-debtors-selected-debtors-msg-1">'
                . Yii::t('app', 'Выбрано %s должников.') . '</span>&nbsp;&nbsp;<span id="dynagrid-debtors-selected-debtors-msg-2"></span>'
                . '</span>',
        ],
        'pager' => [
            'firstPageLabel' => Yii::t('app', 'Первая'),
            'lastPageLabel' => Yii::t('app', 'Последняя'),
        ],
        'options' => ['id' => 'dynagrid-debtors-options' . $functionType],
        'toolbar' => [
            [
                'content' => ($functionType == 'funct_1') ? '' : '<span id="dynagrid-debtors-change-status" data-toggle="modal" data-target="#statusesModal" data-type="change_selected">Изменить статус выбранных должников</span>'
                    . Html::button('<i class="glyphicon glyphicon-list-alt"></i>',
                        [
                            'type' => 'button',
                            'title' => Yii::t('app', 'Сформировать приложение'),
                            'class' => 'btn btn-success',
                            'id' => 'get_debtor_report',
                            //'href' => Url::to('/office/debtor/create'),
                        ]
                    ) . '&nbsp;&nbsp;' . Html::button('<i class="glyphicon glyphicon-list-alt"></i>',
                        [
                            'type' => 'button',
                            'title' => Yii::t('app', 'Свод начислений по лицевому счету'),
                            'class' => 'btn btn-warning',
                            'id' => 'show_subscription_for_accruals',
                        ]
                    )
            ],
            /*[
                'content' => '{dynagridFilter}{dynagridSort}{dynagrid}'
            ],*/
            //'{export}',
        ],
    ],
    'options' => ['id' => 'dynagrid-debtors' . $functionType] // a unique identifier is important
]);
