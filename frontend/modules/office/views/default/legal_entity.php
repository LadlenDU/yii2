<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
//use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\info\LegalEntity */
/* @var $form ActiveForm */

//TODO: title из БД
?>
<div class="legal_entity">

    <?php $form = ActiveForm::begin(); ?>

    <? /*= $form->field($model, 'user_info_id') */ ?>
    <? /*= $form->field($model, 'registration_date') */ ?>
    <?php
/*    echo $form->field($model, 'birthday')->widget(DatePicker::classname(), [
        'options' => ['placeholder' => Yii::t('app', 'Дата регистрации')],
        'value' => date('d.m.Y', strtotime($model->birthday)),
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'dd.mm.yyyy',
        ]
    ]);
    */?>
    <?= $form->field($model, 'company_name') ?>
    <?= $form->field($model, 'CEO_name') ?>
    <?= $form->field($model, 'INN') ?>
    <?= $form->field($model, 'KPP') ?>
    <?/*= $form->field($model, 'OGRN') */?>
    <?= $form->field($model, 'BIC') ?>
    <?= $form->field($model, 'checking_account_num') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div><!-- legal_entity -->
