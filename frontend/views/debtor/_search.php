<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\DebtorSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="debtor-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'fieldConfig' => [
            'enableLabel' => false,
        ],
    ]); ?>

    <div class="row">

        <div class="col-md-4">
            <?= $form->field($model, 'location_street')->textInput(['placeholder' => Yii::t('app', 'Адрес дома')]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'LS_IKU_provider')->textInput(['placeholder' => Yii::t('app', 'Номер лицевого счета')]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'status')->dropDownList(\common\models\DebtorStatus::STATUSES, ['id' => 'debtorstatus-status-search']); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'location_building')->textInput(['placeholder' => Yii::t('app', '№ помещения')]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'clam_sum_from')->textInput(['placeholder' => Yii::t('app', 'Цена иска от')]) ?>
        </div>

        <div class="col-md-4">
            <?= $form->field($model, 'clam_sum_to')->textInput(['placeholder' => Yii::t('app', 'Цена иска до')]) ?>
        </div>
    </div>


    <? /*= $form->field($model, 'phone') */ ?><!--

    <? /*= $form->field($model, 'LS_EIRC') */ ?>

    <? /*= $form->field($model, 'LS_IKU_provider') */ ?>

    --><? /*= $form->field($model, 'IKU') */ ?>

    <?php // echo $form->field($model, 'space_common') ?>

    <?php // echo $form->field($model, 'space_living') ?>

    <?php // echo $form->field($model, 'ownership_type_id') ?>

    <?php // echo $form->field($model, 'location_id') ?>

    <?php // echo $form->field($model, 'name_id') ?>

    <?php // echo $form->field($model, 'expiration_start') ?>

    <?php // echo $form->field($model, 'debt_total') ?>

    <?php // echo $form->field($model, 'single') ?>

    <?php // echo $form->field($model, 'additional_adjustment') ?>

    <?php // echo $form->field($model, 'subsidies') ?>

    <?php // echo $form->field($model, 'user_id') ?>

    <?php // echo $form->field($model, 'status_id') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Искать'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Сбросить'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
