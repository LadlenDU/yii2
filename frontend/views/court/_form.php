<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Court */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="court-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'district')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'districtId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cityId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'street')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'streetId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'building')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'buildingId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name_of_payee')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'BIC')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'beneficiary_account_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'INN')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'KPP')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'OKTMO')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'beneficiary_bank_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'KBK')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Создать') : Yii::t('app', 'Обновить'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
