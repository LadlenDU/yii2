<?php

//use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\DebtorStatus;
use kartik\file\FileInput;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $debtor common\models\Debtor */
/* @var $debtorStatus common\models\DebtorStatus */
/* @var $fileUploadConfig array */
$fileUploadConfig = [];
?>

<? $form = ActiveForm::begin(
    [
        'layout' => 'horizontal',
    ]
); ?>

<?= $form->field($debtorStatus, 'status')->dropDownList(DebtorStatus::STATUSES); ?>

<?= $form->field($debtorStatus, 'submitted_to_court_start')->widget(DateTimePicker::classname(), [
    'options' => ['placeholder' => 'Введите дату ...'],
    'pluginOptions' => [
        'autoclose' => true,
    ]
]); ?>

<?= $form->field($debtorStatus, 'adjudicated_result')->dropDownList(DebtorStatus::ADJUDICATED_RESULT); ?>

<?= $form->field($debtorStatus, 'adjudicated_decision')->textarea(['rows' => '4']); ?>

<?= $form->field($debtorStatus, 'application_withdrawn_reason')->textarea(['rows' => '4']); ?>

<?= $form->field($debtorStatus, 'debtorStatusFiles[]')->widget(FileInput::classname(), $fileUploadConfig); ?>

<? $form = ActiveForm::end(); ?>
