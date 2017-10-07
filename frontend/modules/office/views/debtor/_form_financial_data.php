<?php
/* @var $this yii\web\View */
/* @var $model common\models\Debtor */
/* @var $form yii\widgets\ActiveForm */
?>

<?= $form->field($model, 'expiration_start')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'debt_total')->textInput(['maxlength' => true]) ?>
