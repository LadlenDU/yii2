<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\info\Company */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="company-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'full_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'short_name')->textInput(['maxlength' => true]) ?>

    <? /*= $form->field($model, 'legal_address_location_id')->textInput() */ ?>
    <?php

    #$this->render('@frontend/modules/office/views/_location', ['model' => $model->legalAddressLocation]);
    echo Yii::$app->controller->renderPartial('@frontend/modules/office/views/_location',
        [
            'form' => $form,
            'model' => $model->legalAddressLocation,
        ]
    );

    ?>

    <?= $form->field($model, 'actual_address_location_id')->textInput() ?>

    <?= $form->field($model, 'INN')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'KPP')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'BIK')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'OGRN')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'checking_account')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'correspondent_account')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'full_bank_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CEO')->textInput() ?>

    <?= $form->field($model, 'operates_on_the_basis_of')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fax')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Создать') : Yii::t('app', 'Обновить'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
