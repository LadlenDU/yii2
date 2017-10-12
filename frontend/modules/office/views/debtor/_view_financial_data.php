<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\dynagrid\DynaGrid;
use yii\helpers\Url;
use \common\models\DebtDetails;
use \common\models\DebtDetailsSearch;

/* @var $this yii\web\View */
/* @var $model common\models\Debtor */

//$modelDebtDetails = DebtDetails::find()->where(['debtor_id' => $model->id])->all();

#$searchModel = new DebtDetailsSearch();
#$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

//$searchModel = new DebtorSearch();
//$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

/*echo DetailView::widget([
    'model' => $model,
    'attributes' => [
        'expiration_start',
        'debt_total',
    ],
]);*/

/*foreach ($model->debtDetails as $detail) {
    echo DetailView::widget([
        'model' => $detail,
        'attributes' => [
            'amount',
            'amount_additional_services',
            'date',
            'payment_date',
            'public_service_id',
            'incoming_balance_debit',
            'incoming_balance_credit',
            'charges_permanent',
            'accrued_subsidies',
            'one_time_charges',
            'paid',
            'paid_insurance',
            'grants_paid',
            'outgoing_balance_debit',
            'outgoing_balance_credit',
            'overdue_debts',
            [
                'attribute' => Yii::t('app', 'Пеня'),
                'value' => function (\common\models\Debtor $model, $key, $index) {
                    return $model->calcFine();
                },
                'format' => ['decimal', 2],
                'hAlign' => 'right',
            ],
        ],
    ]) . '<hr><br>';
}*/

$columns = [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'order' => DynaGrid::ORDER_FIX_LEFT,
    ],
/*    [
        'class' => 'yii\grid\ActionColumn',
        'buttons' => [
            'view' => function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, ['class' => 'view', 'data-pjax' => '0']);
            },
            'update' => function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, ['class' => 'view', 'data-pjax' => '0']);
            },
        ],
    ],*/
    ['attribute' => 'amount'],
    ['attribute' => 'amount_additional_services'],
    ['attribute' => 'date'],
    ['attribute' => 'payment_date'],
    ['attribute' => 'public_service_id'],
    ['attribute' => 'incoming_balance_debit'],
    ['attribute' => 'incoming_balance_credit'],
    ['attribute' => 'charges_permanent'],
    ['attribute' => 'accrued_subsidies'],
    ['attribute' => 'one_time_charges'],
    ['attribute' => 'paid'],
    ['attribute' => 'paid_insurance'],
    ['attribute' => 'grants_paid'],
    ['attribute' => 'outgoing_balance_debit'],
    ['attribute' => 'outgoing_balance_credit'],
    ['attribute' => 'overdue_debts'],
   /* [
        'attribute' => Yii::t('app', 'Пеня'),
        'value' => function (\common\models\Debtor $model, $key, $index) {
            return $model->calcFine();
        },
        'format' => ['decimal', 2],
        'hAlign' => 'right',
    ],*/
    /*['attribute' => 'LS_EIRC'],
    ['attribute' => 'LS_IKU_provider'],
    ['attribute' => 'IKU'],
    ['attribute' => 'location.region'],
    ['attribute' => 'name.first_name'],
    ['attribute' => 'expiration_start'],
    [
        'attribute' => 'debt_total',
        'format' => ['decimal', 2],
        'hAlign' => 'right',
    ],*/
    [
        'attribute' => Yii::t('app', 'Пошлина'),
        'value' => function (DebtDetails $model, $key, $index) {
            return $model->calculateStateFee2();
        },
        'format' => ['decimal', 2],
        'hAlign' => 'right',
    ],
    [
        'attribute' => Yii::t('app', 'Пеня'),
        'value' => function (DebtDetails $model, $key, $index) {
            return $model->calcFine();
        },
        'format' => ['decimal', 2],
        'hAlign' => 'right',
    ],
];

$searchModel = new DebtDetailsSearch();
//$searchModel = $searchModel::find()->where(['debtor_id' => $model->id]);
//$dataProvider = $searchModel::find()->where(['debtor_id' => $model->id])->search(Yii::$app->request->queryParams);
//$dataProvider = $searchModel->search(['debtor_id' => $model->id] + Yii::$app->request->queryParams);
$dataProvider = $searchModel->search(['debtor_id' => $model->id]);

echo DynaGrid::widget([
    'columns' => $columns,
    'storage' => DynaGrid::TYPE_COOKIE,
    'theme' => 'simple-striped',
    'gridOptions' => [
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax' => true,
        'panel' => [
            'heading' => '<h3 class="panel-title">' . Yii::t('app', 'Список задолженностей') . '</h3>',
            'before' => '{dynagrid}',
        ],
        'options' => ['id' => 'dynagrid-debtors-options'],
        'toolbar' => [
            [
                'content' =>
                    Html::button('<i class="glyphicon glyphicon-plus"></i>',
                        [
                            'type' => 'button',
                            'title' => Yii::t('app', 'Добавить долг'),
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
