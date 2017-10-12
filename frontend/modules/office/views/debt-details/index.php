<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Debt Details');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="debt-details-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Debt Details'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'debtor_id',
            'amount',
            'amount_additional_services',
            'date',
            // 'payment_date',
            // 'public_service_id',
            // 'incoming_balance_debit',
            // 'incoming_balance_credit',
            // 'charges_permanent',
            // 'accrued_subsidies',
            // 'one_time_charges',
            // 'paid',
            // 'paid_insurance',
            // 'grants_paid',
            // 'outgoing_balance_debit',
            // 'outgoing_balance_credit',
            // 'overdue_debts',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
