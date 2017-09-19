<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Court */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Court',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Суды'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Обновить');
?>
<div class="court-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
