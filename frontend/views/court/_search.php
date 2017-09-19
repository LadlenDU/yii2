<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CourtSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="court-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'address') ?>

    <?= $form->field($model, 'district') ?>

    <?= $form->field($model, 'districtId') ?>

    <?php // echo $form->field($model, 'city') ?>

    <?php // echo $form->field($model, 'cityId') ?>

    <?php // echo $form->field($model, 'street') ?>

    <?php // echo $form->field($model, 'streetId') ?>

    <?php // echo $form->field($model, 'building') ?>

    <?php // echo $form->field($model, 'buildingId') ?>

    <?php // echo $form->field($model, 'phone') ?>

    <?php // echo $form->field($model, 'name_of_payee') ?>

    <?php // echo $form->field($model, 'BIC') ?>

    <?php // echo $form->field($model, 'beneficiary_account_number') ?>

    <?php // echo $form->field($model, 'INN') ?>

    <?php // echo $form->field($model, 'KPP') ?>

    <?php // echo $form->field($model, 'OKTMO') ?>

    <?php // echo $form->field($model, 'beneficiary_bank_name') ?>

    <?php // echo $form->field($model, 'KBK') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
