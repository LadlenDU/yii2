<?php

//use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\DebtorStatus;

/* @var $this yii\web\View */
/* @var $debtor common\models\Debtor */
/* @var $debtorStatus common\models\DebtorStatus */
?>

<? $form = ActiveForm::begin(); ?>

<?= $form->field($debtorStatus, 'status')->dropDownList(DebtorStatus::STATUSES); ?>

<? $form = ActiveForm::end(); ?>
