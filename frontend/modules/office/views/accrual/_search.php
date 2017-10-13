<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AccrualSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="accrual-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'debtor_id') ?>

    <?= $form->field($model, 'accrual_date') ?>

    <?= $form->field($model, 'accrual') ?>

    <?= $form->field($model, 'single') ?>

    <?php // echo $form->field($model, 'additional_adjustment') ?>

    <?php // echo $form->field($model, 'subsidies') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
