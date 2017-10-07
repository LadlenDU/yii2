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

    <?= $form->field($model, 'phone') ?>

    <?= $form->field($model, 'LS_EIRC') ?>

    <?= $form->field($model, 'LS_IKU_provider') ?>

    <?= $form->field($model, 'IKU') ?>

    <?php // echo $form->field($model, 'space_common') ?>

    <?php // echo $form->field($model, 'space_living') ?>

    <?php // echo $form->field($model, 'ownership_type_id') ?>

    <?php // echo $form->field($model, 'location_id') ?>

    <?php // echo $form->field($model, 'name_id') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Поиск'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Сброс'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
