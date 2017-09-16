<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\UserInfo */
/* @var $form ActiveForm */
/* @var $title string */

use common\models\RegistrationType;

$this->title = $title;
$regType = new RegistrationType;
?>
<div class="registration-init">

    <?php $form = ActiveForm::begin(); ?>

    <?/*= Html::activeDropDownList($regType, 'id', $regType->getIdNamePairs()) */?>
    <?= $form->field($model, 'registration_type_id') ?>
    <br>
    <br>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div><!-- registration-init -->
