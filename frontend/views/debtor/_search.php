<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\DebtorSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="debtor-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">

        <div class="col-md-4 col-sm-4">
            <?= $form->field($model, 'location_street')->textInput(['placeholder' => 'Адрес дома']) ?>
        </div>

        <div class="col-md-4 col-sm-4">
            <?= $form->field($model, 'location_building')->textInput(['placeholder' => '№ помещения']) ?>
        </div>

        <div class="col-md-4 col-sm-4">
            <?= $form->field($model, 'LS_IKU_provider')->textInput(['placeholder' => 'Номер лицевого счета']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6 col-md-4">

            <div class="row">
                <div class="col-md-6 col-xs-6">
                    <?= $form->field($model, 'debt_sum_from')->textInput(['placeholder' => 'Сумма долга от']) ?>
                </div>

                <div class="col-md-6 col-xs-6">
                    <?= $form->field($model, 'debt_sum_to')->textInput(['placeholder' => 'Сумма долга до']) ?>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-4">

            <div class="row">
                <div class="col-md-6 col-xs-6 no-padding-right">
                    <?= $form->field($model, 'month_amount_from')->textInput(['placeholder' => 'Кол-во месяцев от']) ?>
                </div>

                <div class="col-md-6 col-xs-6 no-padding-right">
                    <?= $form->field($model, 'month_amount_to')->textInput(['placeholder' => 'Кол-во месяцев до']) ?>
                </div>
            </div>
        </div>

    </div>


    <?= $form->field($model, 'phone') ?>

    <?= $form->field($model, 'LS_EIRC') ?>

    <?= $form->field($model, 'LS_IKU_provider') ?>

    <?= $form->field($model, 'IKU') ?>

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
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
