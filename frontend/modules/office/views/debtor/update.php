<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Debtor */

$this->title = Yii::t('app', 'Обновить данные {modelClass}', ['modelClass' => 'должника',]);

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Должники'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Обновить');
?>
<div class="debtor-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
