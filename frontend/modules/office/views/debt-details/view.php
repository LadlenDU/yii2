<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\DebtDetails */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Детали задолженности'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="debt-details-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'debtor_id',
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
        ],
    ]) ?>

</div>
