<?php

//use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\dynagrid\DynaGrid;
use kartik\helpers\Html;
use yii\helpers\Url;
use \common\models\DebtDetails;
use \common\models\DebtDetailsSearch;
use kartik\tabs\TabsX;

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
    [
        'class' => 'yii\grid\ActionColumn',
    ],
    ['attribute' => 'сharged'],
    ['attribute' => 'paid'],
    ['attribute' => 'debt'],
    /*['attribute' => 'amount'],
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
    ['attribute' => 'overdue_debts'],*/
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

?>

    <div class="row">
        <div class="col-sm-3">
            <?= Yii::t('app', 'Начислено') ?>
        </div>
        <div class="col-sm-3">
            <?= Yii::t('app', 'Оплачено') ?>
        </div>
        <div class="col-sm-3">
            <?= Yii::t('app', 'Задолженность') ?>
        </div>
        <div class="col-sm-3">
            <?= Yii::t('app', 'Пеня') ?>
        </div>
    </div>
<br>
<?php

echo '<div style="text-align: center">' . Html::radioButtonGroup('fin_data', '1',
    [
        0 => Yii::t('app', 'Общая информация'),
        1 => Yii::t('app', 'Начислено'),
        2 => Yii::t('app', 'Оплачено'),
        3 => Yii::t('app', 'Пеня')
    ]
) . '</div>';

/*$tabItems = [
    [
        'label' => '<i class="glyphicon glyphicon-list-alt"></i>' . Yii::t('app', 'Начислено'),
        //'content' => $this->render('_form_common_data', ['form' => $form, 'model' => $model]),
        'content' => 'sdfdsf',
        'active' => true,
    ],
    [
        'label' => '<i class="glyphicon glyphicon-folder-open"></i>' . Yii::t('app', 'Оплачено'),
        'content' => 'empty',
    ],
    [
        'label' => '<i class="glyphicon glyphicon-usd"></i>' . Yii::t('app', 'Пеня'),
        //'content' => $this->render('_form_financial_data', ['form' => $form, 'model' => $model]),
        'content' => 'sdfdsfssss',
    ],
];

echo TabsX::widget([
    'items' => $tabItems,
    'position' => TabsX::POS_RIGHT,
    'encodeLabels' => false,
]);*/

DynaGrid::widget([
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
        'options' => ['id' => 'dynagrid-debts-options'],
        'toolbar' => [
            [
                'content' =>
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>',
                        ['/office/debt-details/create', 'id' => $model->id],
                        [
                            'class' => 'btn btn-success',
                            'title' => Yii::t('app', 'Добавить задолженность'),
                            //'href' => Url::to(['/office/debt-details/create', 'id' => $model->id]),
                        ]
                    ) .
                    Html::button('<i class="glyphicon glyphicon-plus"></i>',
                        [
                            'type' => 'button',
                            'title' => Yii::t('app', 'Добавить долг'),
                            'class' => 'btn btn-success',
                            'href' => Url::to(['/office/debt-details/create', 'id' => $model->id]),
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
    'options' => ['id' => 'dynagrid-debts'] // a unique identifier is important
]);
