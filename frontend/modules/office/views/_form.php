<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Accrual */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="accrual-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'debtor_id')->textInput() ?>

    <?= $form->field($model, 'accrual_date')->textInput() ?>

    <?= $form->field($model, 'accrual')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'single')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'additional_adjustment')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'subsidies')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
