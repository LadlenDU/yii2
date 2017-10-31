<?php

/* @var $this yii\web\View */
/* @var $model common\models\info\Company */
/* @var $form yii\widgets\ActiveForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>

<div class="company-form">

    <?php $form = ActiveForm::begin([
        'layout' => 'horizontal',
        'options' => ['class' => 'jkh-standart-form'],
        /*'options' => ['class' => 'form-horizontal jkh-standart-form'],
        'fieldConfig' => [
            'template' => '<div class="col-lg-3 jkh-standart-form-label">{label}</div><div class="col-lg-9">{input}</div><div class="col-lg-12 col-lg-offset-3">{error}</div>',
            'label' => 'sdfsdf',
            //'labelOptions' => ['class' => ''],
        ],*/

    ]); ?>

    <?= $form->field($model, 'full_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'short_name')->textInput(['maxlength' => true]) ?>

    <? /*= $form->field($model, 'legal_address_location_id')->textInput() */ ?>
    <?php

    echo $this->render('@frontend/modules/office/views/_location',
        [
            'form' => $form,
            'model' => $model->legalAddressLocation
        ]
    );
    /*echo Yii::$app->controller->renderPartial('@frontend/modules/office/views/_location',
        [
            'form' => $form,
            'model' => $model->legalAddressLocation,
        ]
    );*/

    ?>

    <?= $form->field($model, 'actual_address_location_id')->textInput() ?>

    <?= $form->field($model, 'INN')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'KPP')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'BIK')->textInput(['maxlength' => true]) ?>

    <?/*= $form->field($model, 'OGRN')->textInput(['maxlength' => true]) */?>

    <?= $form->field($model, 'checking_account')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'correspondent_account')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'full_bank_name')->textInput(['maxlength' => true]) ?>

    <hr>

    <?= $form->field($model, 'CEO_first_name')->textInput() ?>
    <?= $form->field($model, 'CEO_last_name')->textInput() ?>
    <?= $form->field($model, 'CEO_patronymic')->textInput() ?>

    <hr>

    <?= $form->field($model, 'operates_on_the_basis_of')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fax')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Создать') : Yii::t('app', 'Обновить'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
