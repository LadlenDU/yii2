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

echo $this->render('/message', [
    'title'  => $title,
    'module' => $module,
]);
?>
<div class="registration-type">

    <?php $form = ActiveForm::begin(); ?>

    <?= Html::activeDropDownList($regType, 'id', $regType->getIdNamePairs()) ?>

<?/*= $form->field($model, 'name') */?><!--
<?/*= $form->field($model, 'short_name') */?>
--><?/*= $form->field($model, 'table_name') */?>

<div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Дальше'), ['class' => 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>

</div><!-- registration-type -->
