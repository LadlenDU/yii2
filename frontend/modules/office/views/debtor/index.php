<?php

/* @var $this yii\web\View */
/* @var $searchModel common\models\DebtorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $uploadModel common\models\UploadForm */

use yii\helpers\Html;

//use yii\grid\GridView;
//use yii\widgets\Pjax;
use kartik\dynagrid\DynaGrid;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use common\models\Debtor;
//use yii\widgets\ActiveForm;
use common\models\DebtorStatus;

$this->title = Yii::t('app', 'Работа с должниками');
$this->params['breadcrumbs'][] = $this->title;

$getStatusInfoUrl = json_encode(Url::to('/office/debtor-status/?', true));

$ajaxLoader = json_encode(\common\helpers\HtmlHelper::getCenteredAjaxLoadImg());

$this->registerJs(<<<JS
    $('#statusesModal').on('show.bs.modal', function(e) {
        
        //TODO: не очень уверен в правильности решения
        if (e.namespace != 'bs.modal') {
            return;
        }
        
        $(e.currentTarget).find('.modal-body').html($ajaxLoader);
        
        //TODO: почему-то происходит редирект при 404
        var debtorId = $(e.relatedTarget).data('debtor-id');
        $(e.currentTarget).find('.modal-body').load($getStatusInfoUrl + $.param({debtorId:debtorId}),
            function(response, status, xhr) {
                if (status == "error") {
                    var msg = "Произошла ошибка: ";
                    $(this).html(msg + xhr.status + " " + xhr.statusText);
                }
                return true;
            }
        );
    });

    $("#statusesModal .submit").click(function() {
        $("#debtor-status-form").submit();
    });
JS
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
    //['attribute' => 'id'],
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

    //['attribute' => 'phone'],
//    ['attribute' => 'LS_EIRC'],
//    ['attribute' => 'IKU'],
    /*['attribute' => 'space_common'],
    ['attribute' => 'space_living'],
    ['attribute' => 'privatized'],*/
//    ['attribute' => 'location.region'],
//    ['attribute' => 'name.first_name'],
//    ['attribute' => 'expiration_start'],
//    [
//        'attribute' => 'debt_total',
//        'format' => ['decimal', 2],
//        'hAlign' => 'right',
//    ],
    /*[
        'attribute' => Yii::t('app', 'Пошлина'),
        'value' => function (\common\models\DebtDetails $model, $key, $index) {
            return $model->calculateStateFee2();
        },
        'format' => ['decimal', 2],
        'hAlign' => 'right',
    ],*/
    /*[
        'attribute' => Yii::t('app', 'Пеня'),
        'value' => function (Debtor $model, $key, $index) {
            return $model->calcFine();
        },
        'format' => ['decimal', 2],
        'hAlign' => 'right',
    ],*/
    /*[
        //TODO: разобраться с label
        'attribute' => 'LS_IKU_provider',
        'label' => Yii::t('app', '№ ЛС'),
        'value' => 'debtor.LS_IKU_provider',
    ],
    [
        'attribute' => 'IKU',
        'label' => Yii::t('app', 'ИКУ'),
        'value' => 'debtor.IKU',
    ],
    [
        'attribute' => 'name_mixed',
        'label' => Yii::t('app', 'ФИО'),
        'value' => 'debtor.name.full_name',
    ],
    [
        'attribute' => 'city',
        'label' => Yii::t('app', 'Населённый пункт'),
        'value' => 'debtor.location.city',
    ],
    [
        'attribute' => 'street',
        'label' => Yii::t('app', 'Улица'),
        'value' => 'debtor.location.street',
    ],
    [
        'attribute' => 'building',
        'label' => Yii::t('app', 'Дом'),
        'value' => 'debtor.location.building',
    ],
    [
        'attribute' => 'appartment',
        'label' => Yii::t('app', 'Квартира'),
        'value' => 'debtor.location.appartment',
    ],
    [
        'attribute' => 'privatized',
        'label' => Yii::t('app', 'Тип'),
        'value' => function ($model, $key, $index) {
            //TODO: исправить костыль
            return $model->debtor->privatized ? 'Приватизированное' : 'Муниципальное';
        },
        'format' => 'raw',
    ],
    [
        'attribute' => 'phone',
        'label' => Yii::t('app', 'Телефон'),
        'value' => 'debtor.phone',
    ],
    [
        'attribute' => 'amount',
        'label' => Yii::t('app', 'Сумма долга'),
        'format' => ['decimal', 2],
        'hAlign' => 'right',
        //'pageSummary' => true,
        'pageSummary' => function () {
            return DebtDetailsExt::getTotalOfColumn('amount');
        },
    ],
    [
        'attribute' => 'amount_additional_services',
        'label' => Yii::t('app', 'Сумма долга с допуслугами'),
        'format' => ['decimal', 2],
        'hAlign' => 'right',
    ],

    [
        'attribute' => 'outgoing_balance_debit',
        'format' => ['decimal', 2],
        'hAlign' => 'right',
        'pageSummary' => function () {
            return DebtDetailsExt::getTotalOfColumn('outgoing_balance_debit');
        },
    ],
    [
        'attribute' => 'outgoing_balance_credit',
        'format' => ['decimal', 2],
        'hAlign' => 'right',
        'pageSummary' => function () {
            return DebtDetailsExt::getTotalOfColumn('outgoing_balance_credit');
        },
    ],
    [
        'attribute' => 'overdue_debts',
        'format' => ['decimal', 2],
        'hAlign' => 'right',
        'pageSummary' => function () {
            return DebtDetailsExt::getTotalOfColumn('overdue_debts');
        },
    ],

    [
        'attribute' => Yii::t('app', 'Пошлина'),
        'value' => function (\common\models\DebtDetails $model, $key, $index) {
            return $model->calculateStateFee2();
        },
        'format' => ['decimal', 2],
        'hAlign' => 'right',
    ],*/
];

?>

<!--<div class="arrow-steps clearfix">
    <div class="step"><span><? /*= Yii::t('app', 'Досудебная практика') */ ?></span></div>
    <div class="step current"><span><? /*= Yii::t('app', 'Судебная практика') */ ?></span></div>
    <div class="step"><span> <? /*= Yii::t('app', 'Исполнительное производство') */ ?></span></div>
</div>-->

<?php
echo $this->render('_extensions', compact('uploadModel', 'searchModel', 'showSearchPane'));//['uploadModel' => $uploadModel, 'searchModel' => $searchModel, '$showSearchPane']);
?>

<div class="debtor-index">

    <!--    <h1><? /*= Html::encode($this->title) */ ?></h1>
    <?php /*// echo $this->render('_search', ['model' => $searchModel]); */ ?>

    <p>
        <? /*= Html::a(Yii::t('app', 'Создать должника'), ['create'], ['class' => 'btn btn-success']) */ ?>
    </p>-->
    <?php /*Pjax::begin(); */ ?><!--    <? /*= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'phone',
            'LS_EIRC',
            'LS_IKU_provider',
            'IKU',
            // 'space_common',
            // 'space_living',
            // 'privatized',
            // 'location_id',
            // 'name_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); */ ?>
<?php /*Pjax::end(); */ ?></div>-->

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
                'before' => '{dynagrid}<span id="dynagrid-debtors-selected-debtors"><span id="dynagrid-debtors-selected-debtors-msg-1">'
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
                    'content' => '<span id="dynagrid-debtors-select-all-status">Изменить статус выбранных должников</span>' .
                        Html::button('<i class="glyphicon glyphicon-list-alt"></i>',
                            [
                                'type' => 'button',
                                'title' => Yii::t('app', 'Получить отчет о выбранных должниках'),
                                'class' => 'btn btn-success',
                                'id' => 'get_debtor_report',
                                //'href' => Url::to('/office/debtor/create'),
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
    ]);

    /*yii\bootstrap\Modal::begin([
        'headerOptions' => ['id' => 'modalHeader'],
        'id' => 'modal',
        'size' => 'modal-lg',
        //keeps from closing modal with esc key or by clicking out of the modal.
        // user must click cancel or X to close
        'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
    ]);
    echo "<div id='modalContent'>SOME MODAL CONTENT</div>";
    yii\bootstrap\Modal::end();*/

    $loading = '<div style="text-align: center">' . Html::img('/img/loading.gif', [
            'alt' => Yii::t('app', 'Загрузка...'),
            'style' => 'margin:1em',
        ]) . '</div>';

    $totalDebtors = (int)$dataProvider->getTotalCount();

    $this->registerJs(<<<JS
        $(document).on('ready pjax:success', function() {  // 'pjax:success' use if you have used pjax
            $('.view').click(function(e){
               e.preventDefault();
               var pModal = $('#pModal');
               pModal.find('.modal-content').html('$loading');
               pModal.modal('show').find('.modal-content').load($(this).attr('href'));
           });
        });

        $("#dynagrid-debtors-options-container").prepend('<input type="hidden" name="selected_all_total" id="debtors-selected-all-total" value="0">');

        var txtElem1 = $("#dynagrid-debtors-selected-debtors-msg-1");
        var txtElem2 = $("#dynagrid-debtors-selected-debtors-msg-2");
        var dynagridDebtors = $("#dynagrid-debtors");
        
        var debtorsSelectedText = function(num) {
            return 'Выбрано должников: %s.'.replace('%s', num);
        }
        
        var debtorsSelectedTextSelectAll = function(num) {
            return 'Выбрать всех должников (%s).'.replace('%s', num);
        }
        
        var setSelectedOnCurrentPageOnly = function() {
            var keys = $('#dynagrid-debtors-options').yiiGridView('getSelectedRows');
            txtElem1.text(debtorsSelectedText(keys.length));
        }
        
        var uncheckAllDebtors = function() {
            dynagridDebtors.find(".select-on-check-all").prop('checked', false);
            dynagridDebtors.find(".sgkh-debtor-check").prop('checked', false);
        }
        
        var debtorSeletionChanged = function() {
            var totalSelected;
            if (+$("#debtors-selected-all-total").val()) {
                totalSelected = $totalDebtors;
            } else {
                var keys = $('#dynagrid-debtors-options').yiiGridView('getSelectedRows');
                totalSelected = keys.length;
            }
            if (totalSelected >= 10 && totalSelected <= 50) {
                $("#dynagrid-debtors-select-all-status").show();
            } else {
                $("#dynagrid-debtors-select-all-status").hide();
            }
        }
        
        dynagridDebtors.find(".select-on-check-all").change(function(){
            var checked = $(this).is(':checked');
            var msgElem = $("#dynagrid-debtors-selected-debtors");
            if (checked) {
                setSelectedOnCurrentPageOnly();
                txtElem2.text(debtorsSelectedTextSelectAll($totalDebtors));
                msgElem.fadeIn();
            } else {
                msgElem.fadeOut();
            }
            debtorSeletionChanged();
        });
        
        dynagridDebtors.find(".sgkh-debtor-check").change(function(){
            debtorSeletionChanged();
        });
        
        $("#dynagrid-debtors-selected-debtors-msg-2").click(function(){
            var hiddenSelectedAll = $("#debtors-selected-all-total");
            var selected = +hiddenSelectedAll.val();
            var txt2;
            if (selected) {
                txt2 = debtorsSelectedTextSelectAll($totalDebtors);
                setSelectedOnCurrentPageOnly();
                uncheckAllDebtors();
            } else {
                txtElem1.text(debtorsSelectedText($totalDebtors));
                txt2 = 'Снять выделение со всех должников.';
            }
            txtElem2.text(txt2);
            hiddenSelectedAll.val(+!selected);
        });
        
        $("#dynagrid-debtors-select-all-status").click(function(){
            //var tempHtml = $("#debtor-status-temp").html();
            //$("#statusesModal").find('.modal-body').html(tempHtml).modal('show');
            $("#statusesModal-temp").modal('show');
        });
JS
    );

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
#dynagrid-debtors-select-all-status {
    display: none;
    cursor: pointer;
    border-bottom: 1px dashed;
    margin-right: 2em;
    float: left;
    margin-top: 0.7em;
}
CSS
    );

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

    <div id="statusesModal-temp" class="modal fade" role="dialog">
        <div class="vertical-alignment-helper">
            <div class="modal-dialog vertical-align-center">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><?= Yii::t('app', 'Смена статуса заявления') ?></h4>
                    </div>
                    <div class="modal-body">

                        <form id="debtor-status-form" class="form-horizontal"
                              action="/office/debtor-status?debtorId=25937" method="post" enctype="multipart/form-data">
                            <input name="_csrf-frontend"
                                   value="5p6d1il4NUktzj0bKseKTmKRujLh7n8wQFxPVCOX3ob7yAkD3J7UsX_kB6_V72nxlzsJD2dbXuIifBLTCN3rMQ=="
                                   type="hidden">
                            <div class="form-group field-debtorstatus-status">
                                <label class="control-label col-sm-3" for="debtorstatus-status">Тип статуса</label>
                                <div class="col-sm-9">
                                    <select id="debtorstatus-status" class="form-control" name="DebtorStatus[status]"
                                            maxlength="">
                                        <option value="new" selected="">Новое</option>
                                        <option value="to_work">В работу</option>
                                        <option value="submitted_to_court">Подано в суд</option>
                                        <option value="adjudicated">Вынесено решение</option>
                                        <option value="application_withdrawn">Заявление отозвано</option>
                                    </select>

                                    <div class="help-block help-block-error "></div>
                                </div>
                            </div>
                            <div class="d_status_new show-hide" style="display: block;"></div>
                            <div class="d_status_to_work show-hide" style="display: none;"></div>

                            <div class="d_status_submitted_to_court show-hide" style="display: none;">
                                <div class="form-group field-debtorstatus-submitted_to_court_start">
                                    <label class="control-label col-sm-3" for="debtorstatus-submitted_to_court_start">Начало
                                        суда</label>
                                    <div class="col-sm-9">
                                        <div id="debtorstatus-submitted_to_court_start-datetime"
                                             class="input-group date"><span class="input-group-addon"
                                                                            title="Выбрать дату &amp; время"><span
                                                        class="glyphicon glyphicon-calendar"></span></span><span
                                                    class="input-group-addon" title="Очистить поле"><span
                                                        class="glyphicon glyphicon-remove"></span></span><input
                                                    id="debtorstatus-submitted_to_court_start" class="form-control"
                                                    name="DebtorStatus[submitted_to_court_start]"
                                                    placeholder="Введите дату ..."
                                                    data-krajee-datetimepicker="datetimepicker_48b7abfd" type="text">
                                        </div>

                                        <div class="help-block help-block-error "></div>
                                    </div>
                                </div>
                            </div>

                            <div class="d_status_adjudicated show-hide" style="display: none;">
                                <div class="form-group field-debtorstatus-adjudicated_result">
                                    <label class="control-label col-sm-3" for="debtorstatus-adjudicated_result">Результат
                                        суда</label>
                                    <div class="col-sm-9">
                                        <select id="debtorstatus-adjudicated_result" class="form-control"
                                                name="DebtorStatus[adjudicated_result]">
                                            <option value="positive">Положительный результат</option>
                                            <option value="negative">Отрицательный результат</option>
                                            <option value="settlement_agreement">Мировое соглашение</option>
                                        </select>

                                        <div class="help-block help-block-error "></div>
                                    </div>
                                </div>
                                <div class="form-group field-debtorstatus-adjudicated_decision">
                                    <label class="control-label col-sm-3" for="debtorstatus-adjudicated_decision">Решение
                                        суда</label>
                                    <div class="col-sm-9">
                                        <textarea id="debtorstatus-adjudicated_decision" class="form-control"
                                                  name="DebtorStatus[adjudicated_decision]" rows="4"></textarea>

                                        <div class="help-block help-block-error "></div>
                                    </div>
                                </div>
                            </div>

                            <div class="d_status_application_withdrawn show-hide" style="display: none;">
                                <div class="form-group field-debtorstatus-application_withdrawn_reason">
                                    <label class="control-label col-sm-3"
                                           for="debtorstatus-application_withdrawn_reason">Причина отзыва
                                        заявления</label>
                                    <div class="col-sm-9">
                                        <textarea id="debtorstatus-application_withdrawn_reason" class="form-control"
                                                  name="DebtorStatus[application_withdrawn_reason]" rows="4"></textarea>

                                        <div class="help-block help-block-error "></div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group field-debtorstatus-debtorstatusfiles">
                                <label class="control-label col-sm-3" for="debtorstatus-debtorstatusfiles">Debtor Status
                                    Files</label>
                                <div class="col-sm-9">
                                    <input name="DebtorStatus[debtorStatusFiles][]" value="" type="hidden">
                                    <div class="file-input file-input-new">
                                        <div class="file-preview ">
                                            <button type="button" class="close fileinput-remove">×</button>
                                            <div class="file-drop-disabled">
                                                <div class="file-preview-thumbnails">
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="file-preview-status text-center text-success"></div>
                                                <div class="kv-fileinput-error file-error-message"
                                                     style="display: none;"></div>
                                            </div>
                                        </div>
                                        <div class="kv-upload-progress kv-hidden" style="display: none;">
                                            <div class="progress">
                                                <div class="progress-bar bg-success progress-bar-success progress-bar-striped active"
                                                     role="progressbar" aria-valuenow="0" aria-valuemin="0"
                                                     aria-valuemax="100" style="width:0%;">
                                                    0%
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="input-group file-caption-main">
                                            <div class="file-caption form-control kv-fileinput-caption icon-visible"
                                                 tabindex="500">
                                                <span class="file-caption-icon"><i class="glyphicon glyphicon-file"></i></span>
                                                <input class="file-caption-name" onkeydown="return false;"
                                                       onpaste="return false;" placeholder="Select файлы..."
                                                       title="Дополнительные файлы">
                                            </div>
                                            <div class="input-group-btn">

                                                <button type="button" tabindex="500" title="Отменить текущую загрузку"
                                                        class="btn btn-default btn-secondary kv-hidden fileinput-cancel fileinput-cancel-button">
                                                    <i class="glyphicon glyphicon-ban-circle"></i> <span
                                                            class="hidden-xs">Отмена</span></button>
                                                <button type="submit" tabindex="500" title="Загрузить выбранные файлы"
                                                        class="btn btn-default btn-secondary fileinput-upload fileinput-upload-button">
                                                    <i class="glyphicon glyphicon-upload"></i> <span class="hidden-xs">Загрузить</span>
                                                </button>
                                                <div tabindex="500" class="btn btn-primary btn-file"><i
                                                            class="glyphicon glyphicon-folder-open"></i>&nbsp; <span
                                                            class="hidden-xs">Выбрать …</span><input
                                                            id="debtorstatus-debtorstatusfiles" class=""
                                                            name="DebtorStatus[debtorStatusFiles][]" multiple=""
                                                            accept="application/pdf"
                                                            allowedfileextensions="[&quot;jpeg&quot;,&quot;png&quot;,&quot;pdf&quot;,&quot;doc&quot;,&quot;docx&quot;,&quot;xls&quot;,&quot;xlsx&quot;]"
                                                            initialpreview="{&quot;other&quot;:&quot;width:50px;height:50px;&quot;}"
                                                            data-krajee-fileinput="fileinput_9cb72f2a" type="file">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--[if lt IE 10]><br>
                                    <div class="alert alert-warning"><strong>Примечание:</strong> Ваш браузер не
                                        поддерживает предварительный просмотр и множественную загрузку файлов.
                                        Попробуйте более новую версию или другой браузер, чтобы получить доступ к этим
                                        функциям.
                                    </div>
                                    <script>document.getElementById("debtorstatus-debtorstatusfiles").className.replace(/\bfile-loading\b/, "");
                                    ;</script><![endif]-->

                                    <div class="help-block help-block-error "></div>
                                </div>
                            </div>
                        </form>

                    </div>
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

    <!--<div id="debtor-status-temp" style="display: none">
        <form id="debtor-status-form" class="form-horizontal" action="/office/debtor-status?debtorId=25937"
              method="post" enctype="multipart/form-data">
            <input name="_csrf-frontend"
                   value="5p6d1il4NUktzj0bKseKTmKRujLh7n8wQFxPVCOX3ob7yAkD3J7UsX_kB6_V72nxlzsJD2dbXuIifBLTCN3rMQ=="
                   type="hidden">
            <div class="form-group field-debtorstatus-status">
                <label class="control-label col-sm-3" for="debtorstatus-status">Тип статуса</label>
                <div class="col-sm-9">
                    <select id="debtorstatus-status" class="form-control" name="DebtorStatus[status]" maxlength="">
                        <option value="new" selected="">Новое</option>
                        <option value="to_work">В работу</option>
                        <option value="submitted_to_court">Подано в суд</option>
                        <option value="adjudicated">Вынесено решение</option>
                        <option value="application_withdrawn">Заявление отозвано</option>
                    </select>

                    <div class="help-block help-block-error "></div>
                </div>
            </div>
            <div class="d_status_new show-hide" style="display: block;"></div>
            <div class="d_status_to_work show-hide" style="display: none;"></div>

            <div class="d_status_submitted_to_court show-hide" style="display: none;">
                <div class="form-group field-debtorstatus-submitted_to_court_start">
                    <label class="control-label col-sm-3" for="debtorstatus-submitted_to_court_start">Начало
                        суда</label>
                    <div class="col-sm-9">
                        <div id="debtorstatus-submitted_to_court_start-datetime" class="input-group date"><span
                                    class="input-group-addon" title="Выбрать дату &amp; время"><span
                                        class="glyphicon glyphicon-calendar"></span></span><span
                                    class="input-group-addon" title="Очистить поле"><span
                                        class="glyphicon glyphicon-remove"></span></span><input
                                    id="debtorstatus-submitted_to_court_start" class="form-control"
                                    name="DebtorStatus[submitted_to_court_start]" placeholder="Введите дату ..."
                                    data-krajee-datetimepicker="datetimepicker_48b7abfd" type="text"></div>

                        <div class="help-block help-block-error "></div>
                    </div>
                </div>
            </div>

            <div class="d_status_adjudicated show-hide" style="display: none;">
                <div class="form-group field-debtorstatus-adjudicated_result">
                    <label class="control-label col-sm-3" for="debtorstatus-adjudicated_result">Результат суда</label>
                    <div class="col-sm-9">
                        <select id="debtorstatus-adjudicated_result" class="form-control"
                                name="DebtorStatus[adjudicated_result]">
                            <option value="positive">Положительный результат</option>
                            <option value="negative">Отрицательный результат</option>
                            <option value="settlement_agreement">Мировое соглашение</option>
                        </select>

                        <div class="help-block help-block-error "></div>
                    </div>
                </div>
                <div class="form-group field-debtorstatus-adjudicated_decision">
                    <label class="control-label col-sm-3" for="debtorstatus-adjudicated_decision">Решение суда</label>
                    <div class="col-sm-9">
                        <textarea id="debtorstatus-adjudicated_decision" class="form-control"
                                  name="DebtorStatus[adjudicated_decision]" rows="4"></textarea>

                        <div class="help-block help-block-error "></div>
                    </div>
                </div>
            </div>

            <div class="d_status_application_withdrawn show-hide" style="display: none;">
                <div class="form-group field-debtorstatus-application_withdrawn_reason">
                    <label class="control-label col-sm-3" for="debtorstatus-application_withdrawn_reason">Причина отзыва
                        заявления</label>
                    <div class="col-sm-9">
                        <textarea id="debtorstatus-application_withdrawn_reason" class="form-control"
                                  name="DebtorStatus[application_withdrawn_reason]" rows="4"></textarea>

                        <div class="help-block help-block-error "></div>
                    </div>
                </div>
            </div>

            <div class="form-group field-debtorstatus-debtorstatusfiles">
                <label class="control-label col-sm-3" for="debtorstatus-debtorstatusfiles">Debtor Status Files</label>
                <div class="col-sm-9">
                    <input name="DebtorStatus[debtorStatusFiles][]" value="" type="hidden">
                    <div class="file-input file-input-new">
                        <div class="file-preview ">
                            <button type="button" class="close fileinput-remove">×</button>
                            <div class="file-drop-disabled">
                                <div class="file-preview-thumbnails">
                                </div>
                                <div class="clearfix"></div>
                                <div class="file-preview-status text-center text-success"></div>
                                <div class="kv-fileinput-error file-error-message" style="display: none;"></div>
                            </div>
                        </div>
                        <div class="kv-upload-progress kv-hidden" style="display: none;">
                            <div class="progress">
                                <div class="progress-bar bg-success progress-bar-success progress-bar-striped active"
                                     role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
                                     style="width:0%;">
                                    0%
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="input-group file-caption-main">
                            <div class="file-caption form-control kv-fileinput-caption icon-visible" tabindex="500">
                                <span class="file-caption-icon"><i class="glyphicon glyphicon-file"></i></span>
                                <input class="file-caption-name" onkeydown="return false;" onpaste="return false;"
                                       placeholder="Select файлы..." title="Дополнительные файлы">
                            </div>
                            <div class="input-group-btn">

                                <button type="button" tabindex="500" title="Отменить текущую загрузку"
                                        class="btn btn-default btn-secondary kv-hidden fileinput-cancel fileinput-cancel-button">
                                    <i class="glyphicon glyphicon-ban-circle"></i> <span class="hidden-xs">Отмена</span>
                                </button>
                                <button type="submit" tabindex="500" title="Загрузить выбранные файлы"
                                        class="btn btn-default btn-secondary fileinput-upload fileinput-upload-button">
                                    <i class="glyphicon glyphicon-upload"></i> <span class="hidden-xs">Загрузить</span>
                                </button>
                                <div tabindex="500" class="btn btn-primary btn-file"><i
                                            class="glyphicon glyphicon-folder-open"></i>&nbsp; <span class="hidden-xs">Выбрать …</span><input
                                            id="debtorstatus-debtorstatusfiles" class=""
                                            name="DebtorStatus[debtorStatusFiles][]" multiple=""
                                            accept="application/pdf"
                                            allowedfileextensions="[&quot;jpeg&quot;,&quot;png&quot;,&quot;pdf&quot;,&quot;doc&quot;,&quot;docx&quot;,&quot;xls&quot;,&quot;xlsx&quot;]"
                                            initialpreview="{&quot;other&quot;:&quot;width:50px;height:50px;&quot;}"
                                            data-krajee-fileinput="fileinput_9cb72f2a" type="file"></div>
                            </div>
                        </div>
                    </div>
                    <!--[if lt IE 10]><br>
                    <div class="alert alert-warning"><strong>Примечание:</strong> Ваш браузер не поддерживает
                        предварительный просмотр и множественную загрузку файлов. Попробуйте более новую версию или
                        другой браузер, чтобы получить доступ к этим функциям.
                    </div>
                    <script>document.getElementById("debtorstatus-debtorstatusfiles").className.replace(/\bfile-loading\b/, "");
                    ;</script><![endif]-->

                    <div class="help-block help-block-error "></div>
                </div>
            </div>
        </form>
    </div>-->
