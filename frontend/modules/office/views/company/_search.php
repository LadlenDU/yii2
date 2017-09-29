<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\info\CompanySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="company-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'full_name') ?>

    <?= $form->field($model, 'short_name') ?>

    <?= $form->field($model, 'legal_address_location_id') ?>

    <?= $form->field($model, 'actual_address_location_id') ?>

    <?php // echo $form->field($model, 'INN') ?>

    <?php // echo $form->field($model, 'KPP') ?>

    <?php // echo $form->field($model, 'BIK') ?>

    <?php // echo $form->field($model, 'OGRN') ?>

    <?php // echo $form->field($model, 'checking_account') ?>

    <?php // echo $form->field($model, 'correspondent_account') ?>

    <?php // echo $form->field($model, 'full_bank_name') ?>

    <?php // echo $form->field($model, 'CEO') ?>

    <?php // echo $form->field($model, 'operates_on_the_basis_of') ?>

    <?php // echo $form->field($model, 'phone') ?>

    <?php // echo $form->field($model, 'fax') ?>

    <?php // echo $form->field($model, 'email') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
