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

$this->registerCss(<<<CSS
#debtor-status-form .show-hide {
    display: none;
}
CSS
);

$this->registerJs(<<<JS
$("#debtorstatus-status").change(function () {
    var debtorStatusForm = $("#debtor-status-form");
    var visibleClass = '.d_status_' + $(this).val();
    debtorStatusForm.find(".show-hide").hide();
    debtorStatusForm.find(visibleClass).fadeIn();      
});
JS
);
?>

<? $form = ActiveForm::begin(
    [
        'layout' => 'horizontal',
        'id' => 'debtor-status-form',
    ]
); ?>

<?= $form->field($debtorStatus, 'status')->dropDownList(DebtorStatus::STATUSES, ['maxlength' => true, 'id' => 'debtorstatus-status']); ?>

<div class="d_status_new show-hide"></div>
<div class="d_status_to_work show-hide"></div>

<div class="d_status_submitted_to_court show-hide">
    <?= $form->field($debtorStatus, 'submitted_to_court_start')->widget(DateTimePicker::classname(), [
        'options' => ['placeholder' => 'Введите дату ...'],
        'pluginOptions' => [
            'autoclose' => true,
        ]
    ]); ?>
</div>

<div class="d_status_adjudicated show-hide">
    <?= $form->field($debtorStatus, 'adjudicated_result')->dropDownList(DebtorStatus::ADJUDICATED_RESULT); ?>
    <?= $form->field($debtorStatus, 'adjudicated_decision')->textarea(['rows' => '4']); ?>
</div>

<div class="d_status_application_withdrawn show-hide">
    <?= $form->field($debtorStatus, 'application_withdrawn_reason')->textarea(['rows' => '4']); ?>
</div>

<?= $form->field($debtorStatus, 'debtorStatusFiles[]')->widget(FileInput::classname(), $fileUploadConfig); ?>

<? $form = ActiveForm::end(); ?>
