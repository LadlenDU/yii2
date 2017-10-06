<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Debtor */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Должники'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="debtor-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Обновить'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Удалить'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Вы уверены что хотите удалить этот элемент?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'phone',
            'LS_EIRC',
            'LS_IKU_provider',
            'IKU',
            'space_common',
            'space_living',
            'privatized',
            'location_id',
            'name_id',
        ],
    ]) ?>

</div>
