<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Name;

/* @var $this yii\web\View */
/* @var $model common\models\Name */
/* @var $form ActiveForm */

if (!$model) {
    $model = new Name();
}
?>
<div class="name">

    <?= $form->field($model, 'second_name') ?>
    <?= $form->field($model, 'first_name') ?>
    <?= $form->field($model, 'patronymic') ?>
    <?/*= $form->field($model, 'full_name') */?>

</div><!-- _name -->
