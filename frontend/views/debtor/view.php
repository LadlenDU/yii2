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
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Вы уверены что хотите удалить карточку должника?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'first_name',
            'second_name',
            'patronymic',
            'name_mixed',
            'address',
            'region',
            'regionId',
            'district',
            'districtId',
            'city',
            'cityId',
            'street',
            'streetId',
            'building',
            'buildingId',
            'appartment',
            'phone',
            'LS_EIRC',
            'LS_IKU_provider',
            'IKU',
            'space_common',
            'space_living',
            'privatized',
            'general_manager_id',
        ],
    ]) ?>

</div>
