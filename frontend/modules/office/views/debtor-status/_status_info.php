<?php

//use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\DebtorStatus;
use kartik\file\FileInput;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $debtorId integer */
/* @var $debtorStatus common\models\DebtorStatus */
/* @var $fileUploadConfig array */

$this->registerCss(<<<CSS
#debtor-status-form .show-hide {
    display: none;
}
#debtor-status-form textarea {
    height: 7em !important;
}
CSS
);

$this->registerJs(<<<JS
(function(){
    function statusChanged() {
        var debtorStatusForm = $("#debtor-status-form");
        var visibleClass = '.d_status_' + debtorStatusForm.find("#debtorstatus-status").val();
        debtorStatusForm.find(".show-hide").hide();
        debtorStatusForm.find(visibleClass).fadeIn();    
    }
    $("#debtorstatus-status").change(function () {
          statusChanged();
    });
    statusChanged();
})();
JS
);
?>

<? $form = ActiveForm::begin(
    [
        'layout' => 'horizontal',
        'id' => 'debtor-status-form',
        'action' => yii\helpers\Url::to(['/office/debtor-status', 'debtorId' => $debtorId]),
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
        ],
        //'type' => DatePicker::TYPE_BUTTON,
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
