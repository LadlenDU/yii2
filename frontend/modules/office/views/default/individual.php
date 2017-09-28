<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\info\Individual */
/* //@var $locationModel common\models\Location */
/* @var $form ActiveForm */

//TODO: title из БД
?>
<div class="individual">

    <?php $form = ActiveForm::begin(); ?>

    <? /*= $form->field($model, 'user_info_id') */ ?>
    <? /*= $form->field($model, 'birthday') */ ?>
    <?= $form->field($model, 'full_name') ?>
    <?php
    echo $form->field($model, 'birthday')->widget(DatePicker::classname(), [
        'options' => ['placeholder' => Yii::t('app', 'Введите дату рождения')],
        'value' => date('d.m.Y', strtotime($model->birthday)),
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'dd.mm.yyyy',
        ]
    ]);
    ?>
    <?= $form->field($model, 'INN') ?>
    <?= $form->field($model, 'checking_account_num') ?>

    <?= $form->field($model->location->district, 'district') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div><!-- individual -->
