<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\DebtDetails */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Debt Details',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Детали задолженности'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Обновить');
?>
<div class="debt-details-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
