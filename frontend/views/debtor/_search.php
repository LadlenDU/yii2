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

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'first_name') ?>

    <?= $form->field($model, 'second_name') ?>

    <?= $form->field($model, 'patronymic') ?>

    <?= $form->field($model, 'name_mixed') ?>

    <?php // echo $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'region') ?>

    <?php // echo $form->field($model, 'regionId') ?>

    <?php // echo $form->field($model, 'district') ?>

    <?php // echo $form->field($model, 'districtId') ?>

    <?php // echo $form->field($model, 'city') ?>

    <?php // echo $form->field($model, 'cityId') ?>

    <?php // echo $form->field($model, 'street') ?>

    <?php // echo $form->field($model, 'streetId') ?>

    <?php // echo $form->field($model, 'building') ?>

    <?php // echo $form->field($model, 'buildingId') ?>

    <?php // echo $form->field($model, 'appartment') ?>

    <?php // echo $form->field($model, 'phone') ?>

    <?php // echo $form->field($model, 'LS_EIRC') ?>

    <?php // echo $form->field($model, 'LS_IKU_provider') ?>

    <?php // echo $form->field($model, 'IKU') ?>

    <?php // echo $form->field($model, 'space_common') ?>

    <?php // echo $form->field($model, 'space_living') ?>

    <?php // echo $form->field($model, 'privatized') ?>

    <?php // echo $form->field($model, 'general_manager_id') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
