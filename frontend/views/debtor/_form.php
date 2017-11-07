<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Debtor */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="debtor-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'LS_EIRC')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'LS_IKU_provider')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'IKU')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'space_common')->textInput() ?>

    <?= $form->field($model, 'space_living')->textInput() ?>

    <?= $form->field($model, 'ownership_type_id')->textInput() ?>

    <?= $form->field($model, 'location_id')->textInput() ?>

    <?= $form->field($model, 'name_id')->textInput() ?>

    <?= $form->field($model, 'expiration_start')->textInput() ?>

    <?= $form->field($model, 'debt_total')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'single')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'additional_adjustment')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'subsidies')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'status_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
