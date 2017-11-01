<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Location;

/* @var $this yii\web\View */
/* @var $model common\models\Location */
/* @var $form ActiveForm */


#print_r($model);exit;
if (!$model) {
    $model = new Location();
}
?>
<div class="location">

        <?= $form->field($model, 'zip_code') ?>
        <?/*= $form->field($model, 'region') */?>
        <?/*= $form->field($model, 'regionId') */?>
        <?/*= $form->field($model, 'district') */?>
        <?/*= $form->field($model, 'districtId') */?>
        <?= $form->field($model, 'city') ?>
        <?/*= $form->field($model, 'cityId') */?>
        <?= $form->field($model, 'street') ?>
        <?/*= $form->field($model, 'streetId') */?>
        <?= $form->field($model, 'building') ?>
        <?/*= $form->field($model, 'buildingId') */?>
        <?= $form->field($model, 'appartment') ?>
        <?/*= $form->field($model, 'full_address') */?>
    
</div><!-- _location -->
