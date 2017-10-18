<?php

/* @var $this yii\web\View */
/* @var $searchModel common\models\DebtorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $uploadModel common\models\UploadForm */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\dynagrid\DynaGrid;
use yii\helpers\Url;
use yii\bootstrap\Modal;

$this->title = Yii::t('app', 'Должники');
$this->params['breadcrumbs'][] = $this->title;

$columns = [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'order' => DynaGrid::ORDER_FIX_LEFT,
    ],
    [
        'class' => 'yii\grid\ActionColumn',
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
    ],
    //['attribute' => 'id'],
    [
        'attribute' => 'LS_IKU_provider',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'name.full_name',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'location.city',
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'location.address',
        'value' => function (\common\models\Debtor $model, $key, $index) {
            return isset($model->location) ? $model->location->createFullAddress() : '';
        },
        'hAlign' => 'center',
    ],
    [
        'attribute' => 'accrualSum',
        'hAlign' => 'right',
    ],
    [
        'attribute' => 'paymentSum',
        'hAlign' => 'right',
    ],
    [
        'attribute' => 'debtTotal',
        'hAlign' => 'right',
        //'format' => ['decimal', 2],
    ],
    [
        'attribute' => 'fineTotal',
        'hAlign' => 'right',
    ],
    [
        'attribute' => Yii::t('app', 'Пошлина'),
        //'value' => function (\common\models\DebtDetails $model, $key, $index) {
        'value' => function (\common\models\Debtor $model, $key, $index) {
            return $model->calculateStateFee2();
        },
        'format' => ['decimal', 2],
        'hAlign' => 'right',
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
        'value' => function (\common\models\Debtor $model, $key, $index) {
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
    <div class="step"><span><?/*= Yii::t('app', 'Досудебная практика') */?></span></div>
    <div class="step current"><span><?/*= Yii::t('app', 'Судебная практика') */?></span></div>
    <div class="step"><span> <?/*= Yii::t('app', 'Исполнительное производство') */?></span></div>
</div>-->

<?php
    echo $this->render('_extensions', ['uploadModel' => $uploadModel]);
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
        'gridOptions' => [
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax' => true,
            'panel' => [
                'heading' => '<h3 class="panel-title">' . Yii::t('app', 'Список должников') . '</h3>',
                'before' => '{dynagrid}',
            ],
            'options' => ['id' => 'dynagrid-debtors-options'],
            'toolbar' => [
                [
                    'content' =>
                        Html::button('<i class="glyphicon glyphicon-plus"></i>',
                            [
                                'type' => 'button',
                                'title' => Yii::t('app', 'Добавить должника'),
                                'class' => 'btn btn-success',
                                'href' => Url::to('/office/debtor/create'),
                            ]
                        )/* . ' ' .
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
                '{export}',
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

    $this->registerJs(<<<JS
        $(document).on('ready pjax:success', function() {  // 'pjax:success' use if you have used pjax
            $('.view').click(function(e){
               e.preventDefault();
               var pModal = $('#pModal');
               pModal.find('.modal-content').html('$loading');
               pModal.modal('show').find('.modal-content').load($(this).attr('href'));
           });
        });
JS
    );

    $this->registerCss('.modal-content {padding: 1em;}');

    Modal::begin([
        'id' => 'pModal',
        'size' => 'modal-lg',
    ]);
    Modal::end();

    ?>
