<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\dynagrid\DynaGrid;

/* @var $this yii\web\View */
/* @var $searchModel common\models\DebtorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Должники');
$this->params['breadcrumbs'][] = $this->title;

$columns = [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'order' => DynaGrid::ORDER_FIX_LEFT,
    ],
    ['class' => 'yii\grid\ActionColumn'],
    ['attribute' => 'phone'],
    ['attribute' => 'LS_EIRC'],
    ['attribute' => 'LS_IKU_provider'],
    ['attribute' => 'IKU'],
    /*['attribute' => 'space_common'],
    ['attribute' => 'space_living'],
    ['attribute' => 'privatized'],*/
    ['attribute' => 'location.region'],
    ['attribute' => 'name.first_name'],
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
                                'href' => 'google.com'
                            ]
                        ) . ' ' .
                        Html::a('<i class="glyphicon glyphicon-repeat"></i>',
                            ['dynagrid-demo'],
                            [
                                'data-pjax' => 0,
                                'class' => 'btn btn-default',
                                'title' => Yii::t('app', 'Сбросить'),
                            ]
                        ),
                ],
                [
                    'content' => '{dynagridFilter}{dynagridSort}{dynagrid}'
                ],
                '{export}',
            ],
        ],
        'options' => ['id' => 'dynagrid-debtors'] // a unique identifier is important
    ]);
    ?>
