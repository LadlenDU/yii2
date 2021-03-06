<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Location */

$this->title = Yii::t('app', 'Обновить {modelClass}: ', [
    'modelClass' => 'адрес',
]); // . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Адреса'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Обновить');
?>
<div class="location-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
