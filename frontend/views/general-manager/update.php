<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\GeneralManager */

$this->title = Yii::t('app', 'Обновить {modelClass}: ', [
    'modelClass' => 'General Manager',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Генеральные директора'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Обновить');
?>
<div class="general-manager-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
