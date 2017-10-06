<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\tabs\TabsX;

/* @var $this yii\web\View */
/* @var $model common\models\Debtor */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="debtor-form">

    <?php
    $form = ActiveForm::begin();

    $tabItems = [
        [
            'label' => '<i class="glyphicon glyphicon-home"></i>' . Yii::t('app', 'Общие данные'),
            'content' => $this->render('_common_data', ['form' => $form, 'model' => $model]),
            'active' => true,
        ],
        [
            'label' => '<i class="glyphicon glyphicon-user"></i>' . Yii::t('app', 'Документооборот'),
            'content' => 'empty',
        ],
        [
            'label' => '<i class="glyphicon glyphicon-list-alt"></i>' . Yii::t('app', 'Финансовые данные'),
            'content' => $this->render('_financial_data', ['form' => $form, 'model' => $model]),
        ],
    ];

    echo TabsX::widget([
        'items' => $tabItems,
        'position' => TabsX::POS_ABOVE,
        'encodeLabels' => false,
    ]);

    ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Создать') : Yii::t('app', 'Обновить'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
