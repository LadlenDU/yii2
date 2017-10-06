<?php
/* @var $this yii\web\View */
/* @var $model common\models\Debtor */
/* @var $form yii\widgets\ActiveForm */
?>

<?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'LS_EIRC')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'LS_IKU_provider')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'IKU')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'space_common')->textInput() ?>

<?= $form->field($model, 'space_living')->textInput() ?>

<?= $form->field($model, 'privatized')->textInput() ?>

<? /*= $form->field($model, 'location_id')->textInput() */ ?><!--

    --><? /*= $form->field($model, 'name_id')->textInput() */ ?>

<?php

echo $this->render('@frontend/modules/office/views/_location',
    [
        'form' => $form,
        'model' => $model->location,
    ]
);

echo $this->render('@frontend/modules/office/views/_name',
    [
        'form' => $form,
        'model' => $model->name,
    ]
);

?>