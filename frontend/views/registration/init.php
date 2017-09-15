<?php

/**
 * @var yii\web\View $this
 * @var string $title
 * @var dektrium\user\Module $module
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\RegistrationType;

$this->title = $title;

$regType = new RegistrationType;

?>
<div class="registration-type">

    <?php $form = ActiveForm::begin(['action' => '/sdfss']); ?>

    <?= Html::activeDropDownList($regType, 'id', $regType->getIdNamePairs()) ?>
    <br>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Дальше'), ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div><!-- registration-type -->
