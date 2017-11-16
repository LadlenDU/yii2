<?php

/* @var $this yii\web\View */
/* @var $searchModel common\models\DebtorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $uploadModel common\models\UploadForm */
/* @var $applicationPackage array */

use yii\helpers\Html;

//use yii\grid\GridView;
//use yii\widgets\Pjax;
use kartik\dynagrid\DynaGrid;
use yii\bootstrap\Modal;
use common\models\Debtor;
//use yii\widgets\ActiveForm;
use common\models\DebtorStatus;

$this->title = Yii::t('app', 'Работа с должниками');
$this->params['breadcrumbs'][] = $this->title;

$this->render('_index_js', ['dataProvider' => $dataProvider]);

$this->registerCss(<<<CSS
.modal-content {
    padding: 1em;
}
#dynagrid-debtors-selected-debtors {
    display: none;
    margin-left: 2em;
}
#dynagrid-debtors-selected-debtors-msg-2 {
    cursor: pointer;
    border-bottom: 1px dashed;
}
#dynagrid-debtors-change-status {
    display: none;
    cursor: pointer;
    border-bottom: 1px dashed;
    margin-right: 2em;
    float: left;
    margin-top: 0.7em;
}
CSS
);

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

?>

<!--<div class="arrow-steps clearfix">
    <div class="step"><span><? /*= Yii::t('app', 'Досудебная практика') */ ?></span></div>
    <div class="step current"><span><? /*= Yii::t('app', 'Судебная практика') */ ?></span></div>
    <div class="step"><span> <? /*= Yii::t('app', 'Исполнительное производство') */ ?></span></div>
</div>-->

<?php
echo $this->render('_extensions', compact('uploadModel', 'searchModel', 'showSearchPane'));//['uploadModel' => $uploadModel, 'searchModel' => $searchModel, '$showSearchPane']);

$reportHandleButtons = '';
if ($applicationPackage['id']) {
    $reportHandleButtons = '<span style="margin-left:1em">'
        . Html::button('<i class="glyphicon glyphicon-minus"></i>',
            [
                'type' => 'button',
                'title' => Yii::t('app', 'Удалить должника из приложения'),
                'class' => 'btn btn-danger',
                'id' => 'remove_debtors_from_report',
            ]

        )
        . '<span style="margin-left:1em;font-weight:bold">'
        . Yii::t('app', 'Приложение № ' . $applicationPackage['number'])
        . '</span><input type="hidden" id="sgkh-number-of-selected-app" value="' . $applicationPackage['number'] . '"></span>';
}
?>

<div class="debtor-index">
    <?= DynaGrid::widget([
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
            'options' => ['id' => 'dynagrid-debtors-options'],
            'toolbar' => [
                [
                    'content' => '<span id="dynagrid-debtors-change-status" data-toggle="modal" data-target="#statusesModal" data-type="change_selected">Изменить статус выбранных должников</span>' .
                        Html::button('<i class="glyphicon glyphicon-list-alt"></i>',
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
                    /*Html::button('<i class="glyphicon glyphicon-plus"></i>',
                        [
                            'type' => 'button',
                            'title' => Yii::t('app', 'Добавить должника'),
                            'class' => 'btn btn-success',
                            'href' => Url::to('/office/debtor/create'),
                        ]
                    )*/
                    /* . ' ' .
                        Html::a('<i class="glyphicon glyphicon-repeat"></i>',
                            ['dynagrid-demo'],
                            [
                                'data-pjax' => 0,
                                'class' => 'btn btn-default',
                                'title' => Yii::t('app', 'Сбросить'),
                            ]
                        )*/,
                ],
                /*[
                    'content' => '{dynagridFilter}{dynagridSort}{dynagrid}'
                ],*/
                //'{export}',
            ],
        ],
        'options' => ['id' => 'dynagrid-debtors'] // a unique identifier is important
    ]); ?>

    <?php
    Modal::begin([
        'id' => 'pModal',
        'size' => 'modal-lg',
    ]);
    Modal::end();
    ?>

    <div id="statusesModal" class="modal fade" role="dialog">
        <div class="vertical-alignment-helper">
            <div class="modal-dialog vertical-align-center">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><?= Yii::t('app', 'Смена статуса заявления') ?></h4>
                    </div>
                    <div class="modal-body"></div>
                    <div class="modal-footer">
                        <button type="button" class="submit btn btn-success btn-small btn-sm"
                                data-dismiss="modal"><?= Yii::t('app', 'Сохранить') ?></button>
                        <button type="button" class="btn btn-danger btn-small btn-sm"
                                data-dismiss="modal"><?= Yii::t('app', 'Отменить') ?></button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <input type="hidden" name="selected_all_total" id="debtors-selected-all-total" value="0">

    <!--<iframe id="debtor-report-download-frame" style="display:none;"></iframe>-->
