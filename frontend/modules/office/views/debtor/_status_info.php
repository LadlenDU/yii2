<?php

//use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $debtor common\models\Debtor */
/* @var $debtorStatus common\models\DebtorStatus */
?>

<? $form = ActiveForm::begin(); ?>

<?= $form->field($debtorStatus, 'status')->dropDownList($debtorStatus::STATUSES); ?>

<? $form = ActiveForm::end(); ?>
