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

<div class="row tbl-debtor-fin-info">
    <div class="col-sm-3">
        <div class="row">
            <div class="col-sm-12 text-center bg-primary">
                <?= Yii::t('app', 'Начислено') ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 text-center">
                <?= 'test123' ?>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="row">
            <div class="col-sm-12 text-center bg-primary">
                <?= Yii::t('app', 'Оплачено') ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 text-center">
                <?= 'test123' ?>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="row">
            <div class="col-sm-12 text-center bg-primary">
                <?= Yii::t('app', 'Задолженность') ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 text-center">
                <?= 'test123' ?>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="row">
            <div class="col-sm-12 text-center bg-primary">
                <?= Yii::t('app', 'Пеня') ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 text-center">
                <?= 'test123' ?>
            </div>
        </div>
    </div>
</div>
<?php

echo '<div style="text-align: center">' . Html::radioButtonGroup('fin_data', 'common_info',
        [
            'common_info' => Yii::t('app', 'Общая информация'),
            'accrual' => Yii::t('app', 'Начислено'),
            'payed' => Yii::t('app', 'Оплачено'),
            'fine' => Yii::t('app', 'Пеня')
        ]
    ) . '</div>';

$commonUrl = json_encode(Url::to(['/office/debt-details/common-info', 'debtor_id' => $model->id]));
$accrualUrl = json_encode(Url::to(['/office/accrual/info-for-debtor', 'debtor_id' => $model->id]));
$paymentUrl = json_encode(Url::to(['/office/payment/info-for-debtor', 'debtor_id' => $model->id]));
$loaderImg = json_encode('<div style="text-align: center">' . Html::img(Url::to(['/img/ajax-loader.gif'])) . '</div>');

$this->registerJs(<<<JS
var fin_data_events = {};
fin_data_events.container = $("#fin_data_container");
fin_data_events.loadData = function(url) {
    fin_data_events.container.html($loaderImg);
    $.get(url, null, function(html) {
        fin_data_events.container.html(html);
    }, 'html');
};
fin_data_events.loadData($commonUrl);

$('[name=fin_data]').change(function() {
    switch ($(this).val())
    {
        case 'common_info':
            {
                //fin_data_events.commonInfo();
                fin_data_events.loadData($commonUrl);
                break;
            }
        case 'accrual':
            {
                //fin_data_events.accruals();
                fin_data_events.loadData($accrualUrl);
                break;
            }
        case 'payed':
            {
                fin_data_events.loadData($paymentUrl);
                break;
            }
        default:
            {
                break;
            }
    }
});
JS
);
?>

<div id="fin_data_container"></div>
