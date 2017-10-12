<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\DebtDetails */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="debt-details-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'debtor_id')->textInput() ?>

    <?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'amount_additional_services')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date')->textInput() ?>

    <?= $form->field($model, 'payment_date')->textInput() ?>

    <?= $form->field($model, 'public_service_id')->textInput() ?>

    <?= $form->field($model, 'incoming_balance_debit')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'incoming_balance_credit')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'charges_permanent')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'accrued_subsidies')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'one_time_charges')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'paid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'paid_insurance')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'grants_paid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'outgoing_balance_debit')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'outgoing_balance_credit')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'overdue_debts')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
