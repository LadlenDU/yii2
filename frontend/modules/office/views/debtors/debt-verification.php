<?php
/**
 * @var yii\web\View $this
 * @var common\models\UploadForm $uploadModel
 * @var common\models\DebtorSearch $searchModel
 * @var bool $uploaded
 */

#use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\helpers\Enum;
use yii\helpers\Html;
use common\models\Debtor;

#use yiister\adminlte\widgets\grid\GridView;
#use yii\grid\GridView;

use kartik\dynagrid\DynaGrid;
use kartik\grid\GridView;

use andkon\yii2kladr\Kladr;

$columns = [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'order' => DynaGrid::ORDER_FIX_LEFT,
    ],
    /*[
        'attribute' => 'Кв-я',
        'value' => function ($model, $key, $index) {
            return '<button style="height:21px;width:21px;display:inline-block;vertical-align:middle" title="'
                . \Yii::t('app', 'Показать квитанцию') . '" onclick="showInvoice(' . $key . ')"></button>';
        },
        'hAlign' => 'center',
        'vAlign' => 'middle',
        'format' => 'raw',
        'order' => DynaGrid::ORDER_FIX_LEFT,
    ],*/
    //'id',
    //'LS_EIRC',
    [
        'attribute' => 'debtor.LS_EIRC',
        'value' => 'debtor.LS_EIRC',
    ],
    /*[
        'attribute' => 'LS_EIRC',
        'value' => function ($model, $key, $index) {
            return $model->debtor->LS_EIRC;
        },
        'format' => 'raw',
    ],*/
    //'LS_IKU_provider',
    [
        'attribute' => 'debtor.LS_IKU_provider',
        'value' => 'debtor.LS_IKU_provider',
    ],
    /*[
        'attribute' => 'LS_IKU_provider',
        'value' => function ($model, $key, $index) {
            return $model->debtor->LS_IKU_provider;
        },
        'format' => 'raw',
    ],*/
    //'IKU',
    [
        'attribute' => 'debtor.IKU',
        'value' => 'debtor.IKU',
    ],
    /*[
        'attribute' => 'IKU',
        'value' => function ($model, $key, $index) {
            return $model->debtor->IKU;
        },
        'format' => 'raw',
    ],*/
    //'name_mixed',
    [
        'attribute' => 'debtor.name_mixed',
        'value' => 'debtor.name_mixed',
    ],
    /*[
        'attribute' => 'name_mixed',
        'value' => function ($model, $key, $index) {
            return $model->debtor->name_mixed;
        },
        'format' => 'raw',
    ],*/
    //'city',
    [
        'attribute' => 'debtor.city',
        'value' => 'debtor.city',
    ],
    /*[
        'attribute' => 'city',
        'value' => function ($model, $key, $index) {
            return $model->debtor->city;
        },
        'format' => 'raw',
    ],*/
    //'street',
    [
        'attribute' => 'debtor.street',
        'value' => 'debtor.street',
    ],
    /*[
        'attribute' => 'street',
        'value' => function ($model, $key, $index) {
            return $model->debtor->street;
        },
        'format' => 'raw',
    ],*/
    //'building',
    [
        'attribute' => 'debtor.building',
        'value' => 'debtor.building',
    ],
    /*[
        'attribute' => 'building',
        'value' => function ($model, $key, $index) {
            return $model->debtor->building;
        },
        'format' => 'raw',
    ],*/
    //'appartment',
    [
        'attribute' => 'debtor.appartment',
        'value' => 'debtor.appartment',
    ],
    /*[
        'attribute' => 'appartment',
        'value' => function ($model, $key, $index) {
            return $model->debtor->appartment;
        },
        'format' => 'raw',
    ],*/
    //'privatized',
    /*[
        'attribute' => 'privatized',
        'value' => 'debtor.privatized',
    ],*/
    [
        'attribute' => Yii::t('app', 'Тип'),
        'value' => function ($model, $key, $index) {
            //TODO: исправить костыль
            return $model->debtor->privatized ? 'Приватизированное' : 'Муниципальное';
        },
        'format' => 'raw',
    ],
    //'phone',
    [
        'attribute' => 'debtor.phone',
        'value' => 'debtor.phone',
    ],
    /*[
        'attribute' => 'phone',
        'value' => function ($model, $key, $index) {
            return $model->debtor->phone;
        },
        'format' => 'raw',
    ],*/
    'amount',
    /*[
        'attribute' => Yii::t('app', 'Сумма долга'),
        'value' => function ($model, $key, $index) {
            return $model->debtDetails[0]->amount;
        },
        'format' => ['decimal', 2],
        'hAlign' => 'right',
    ],*/
    'amount_additional_services',
    /*[
        'attribute' => Yii::t('app', 'Сумма долга с допуслугами'),
        'value' => function ($model, $key, $index) {
            return $model->debtDetails[0]->amount_additional_services;
        },
        'format' => ['decimal', 2],
        'hAlign' => 'right',
    ],*/
    'payment_date',
    /*[
        'attribute' => Yii::t('app', 'Дата оплаты'),
        'value' => function ($model, $key, $index) {
            //return $model->debtDetails[0]->payment_date;
            // Убираем секунды
            //TODO: здесь возможно надо будет скорректировать
            if ($model->debtDetails[0]->payment_date) {
                return substr($model->debtDetails[0]->payment_date, 0, 10);
            }
            return $model->debtDetails[0]->payment_date;
        },
        'format' => 'raw',
    ],*/
    [
        'attribute' => Yii::t('app', 'Пошлина'),
        'value' => function (\common\models\DebtDetails $model, $key, $index) {
            return $model->debtor->calculateStateFee();
        },
        'format' => ['decimal', 2],
        'hAlign' => 'right',
    ],
];

?>

    <div class="arrow-steps clearfix">
        <div class="step"><span><?= Yii::t('app', 'Досудебная практика') ?></span></div>
        <div class="step current"><span><?= Yii::t('app', 'Судебная практика') ?></span></div>
        <div class="step"><span> <?= Yii::t('app', 'Исполнительное производство') ?></span></div>
    </div>

    <br><br>

    <div class="grid-head">
        <div class="row">
            <div class="col-sm-12 controls-buttons">
                <!--<div class="btn-group">
                <button id="debtors-bottom-menu" class="btn btn-primary btn-sm dropdown-toggle"
                        data-toggle="dropdown" aria-expanded="true">
                    <? /*= Yii::t('app', 'Действия к должникам') */ ?> <b class="caret"></b></button>

                <ul role="menu" class="dropdown-menu">
                    <li id="generate-notice" role="menuitem">
                        <a tabindex="-1" href="javascript:void(0)"><? /*= Yii::t('app', 'Проверка регистрации') */ ?></a>
                    </li>
                    <li id="create-lawsuit" role="menuitem">
                        <a tabindex="-1" href="javascript:void(0)"><? /*= Yii::t('app', 'Проверка задолженности') */ ?></a>
                    </li>
                    <li id="send-sms" visible="1" role="menuitem">
                        <a tabindex="-1" href="javascript:void(0)"><? /*= Yii::t('app', 'Расчет пошлины') */ ?></a>
                    </li>
                </ul>
            </div>-->

                <!--<button class="btn-sm toggle-filter btn btn-primary" id="show_debtors_filter" data-toggle="collapse"
                    data-target="#search-debtors">
                <i class="icon-search icon-white"></i><? /*= Yii::t('app', 'Поиск должников') */ ?>
            </button>-->
                <!--<button class="hide btn-sm btn btn-grey" id="reset-debtors-filter" style="display: none">
                <i class="fa fa-filter"></i><? /*= Yii::t('app', 'Сбросить фильтр') */ ?>
            </button>-->

                <button class="btn-sm toggle-filter btn btn-primary" id="load_debtors" data-toggle="collapse"
                        data-target="#load-debtors"
                        title="<?= Yii::t('app', 'Загрузка должников из файла') ?>">
                    <i class="icon-search icon-white"></i><?= Yii::t('app', 'Загрузка должников') ?>
                </button>

                <button class="btn-sm btn btn-primary" id="print_invoices"
                        title="<?= Yii::t('app', 'Распечатка бланков выбранных должников') ?>">
                    <i class="icon-search icon-white"></i><?= Yii::t('app', 'Распечатка бланков') ?>
                </button>

                <div class="clearfix"></div>
            </div>
            <!--<div class="col-sm-6">
            <div class="pull-right" style="white-space: nowrap;"><? /*= Yii::t('app', 'Показывать записей') */ ?>
                <select id="debtors-grid_sizer" class="page-sizer" name="pageSize_Accounts">
                    <option value="10">10</option>
                    <option value="30">30</option>
                    <option value="50">50</option>
                    <option value="100" selected="selected">100</option>
                </select>
            </div>
        </div>-->
        </div>
    </div>

<?php /* ?>
<div class="row collapse" id="search-debtors">
    <div class="col-xs-12 filters">
        <div id="debtors_free_filter" class="free-filter toggle-container well-info well-sm" style="display: block;">
            <form class="debtors-filter-form form-horizontal" enctype="multipart/form-data" id="debtors-filter-form"
                  action="/debtors/debtors/debtorsList?area=debtors-index_inner_area" method="post">
                <input value="4309dd2f2fa8e357ab2115db35ee846d8e01c525" name="YII_CSRF_TOKEN" type="hidden">
                <div class="row">

                    <div class="col-md-4 col-sm-4 no-padding-right">
                        <!--<div class="lbl"><label for="DebtorsFilterForm_address">Адрес дома</label></div>-->
                        <div class="elm">
                            <select class="col-xs-12 houses_cards_id filterInput chosen-select"
                                    id="DebtorsFilterForm_address" name="DebtorsFilterForm[address]"
                                    style="display: none;">
                                <option value="" selected="selected">- Адрес дома -</option>
                                <option value="17102">Щелково г, д. 31А</option>
                            </select>
                            <div class="chosen-container chosen-container-single" style="width: 0px;" title=""
                                 id="DebtorsFilterForm_address_chosen"><a class="chosen-single" tabindex="-1"><span>- Адрес дома -</span>
                                    <div><b></b></div>
                                </a>
                                <div class="chosen-drop">
                                    <div class="chosen-search"><input autocomplete="off" type="text"></div>
                                    <ul class="chosen-results"></ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-4 no-padding-right">
                        <!--<div class="lbl"><label>Номер квартиры</label></div>-->
                        <div class="elm"><input class="form-control" placeholder="№ помещения"
                                                name="DebtorsFilterForm[flat]" id="DebtorsFilterForm_flat" type="text">
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-4">
                        <!--<div class="lbl"><label>Номер лицевого счета</label></div>-->
                        <div class="elm"><input class="form-control" placeholder="№ лицевого счета"
                                                name="DebtorsFilterForm[account]" id="DebtorsFilterForm_account"
                                                type="text"></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6 col-md-4">

                        <div class="row">
                            <div class="col-md-6 col-xs-6 no-padding-right">
                                <div class="elm"><input class="form-control" placeholder="Сумма долга от"
                                                        name="DebtorsFilterForm[sum_from]"
                                                        id="DebtorsFilterForm_sum_from" type="text"></div>
                            </div>

                            <div class="col-md-6 col-xs-6 no-padding-right">
                                <div class="elm"><input class="form-control" placeholder="Сумма долга до"
                                                        name="DebtorsFilterForm[sum_to]" id="DebtorsFilterForm_sum_to"
                                                        type="text"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-4">

                        <div class="row">
                            <div class="col-md-6 col-xs-6 no-padding-right">
                                <div class="elm"><input class="form-control" placeholder="Кол-во месяцев от"
                                                        name="DebtorsFilterForm[month_from]"
                                                        id="DebtorsFilterForm_month_from" type="text"></div>
                            </div>

                            <div class="col-md-6 col-xs-6 no-padding-right">
                                <div class="elm"><input class="form-control" placeholder="Кол-во месяцев до"
                                                        name="DebtorsFilterForm[month_to]"
                                                        id="DebtorsFilterForm_month_to" type="text"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2  col-sm-2">
                        <div class="lbl"></div>
                        <div class="elm">
                            <a class="btn-sm btn btn-primary" id="process-debtors-filter" href="javascript:void(0)"><i
                                        class="fa fa-search"></i> Найти</a></div>
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>
 */ ?>

    <br>

    <div class="row collapse" id="load-debtors">
        <div class="col-xs-12">
            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
            <?= $form->field($uploadModel, 'excelFile')->fileInput() ?>
            <button><?= Yii::t('app', 'Отправить') ?></button>
            <?php ActiveForm::end() ?>
        </div>
    </div>

    <br>

<?php

echo DynaGrid::widget([
    'columns' => $columns,
    'storage' => DynaGrid::TYPE_COOKIE,
    'theme' => 'simple-striped',
    'gridOptions' => [
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        /*'floatHeader' => true,*/
        'pjax' => true,
        'panel' => [
            'heading' => '<h3 class="panel-title">' . Yii::t('app', 'Список должников') . '</h3>',
            'before' => '{dynagrid}',
        ],
        'options' => ['id' => 'dynagrid-debtors-options'],
    ],
    'options' => ['id' => 'dynagrid-debtors'] // a unique identifier is important
]);
?>

    <script>
        function showInvoice(debtorId) {
            var url = '/office/debtors/invoice-prev/?debtorIds=' + encodeURIComponent(debtorId);
            window.open(url, '_blank');
            //openExcelFile(url);
        }
    </script>

<?php
$script = <<<JS
    $("#print_invoices").click(function () {
        var keys = $('#dynagrid-debtors-options').yiiGridView('getSelectedRows');
        /*for (var k in keys) {
            //console.log(keys[k]);            
        }*/
        var url = '/office/debtors/invoice-prev/?' + $.param({debtorIds:keys});
        window.open(url, '_blank');
    });
JS;
$this->registerJs($script, yii\web\View::POS_READY, 'debt-verification');
