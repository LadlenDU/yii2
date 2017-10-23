<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\info\Company */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Организации'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="company-view">

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
            'full_name',
            'short_name',
            'legal_address_location_id',
            'actual_address_location_id',
            'INN',
            'KPP',
            'BIK',
            'OGRN',
            'checking_account',
            'correspondent_account',
            'full_bank_name',
            'CEO',
            'operates_on_the_basis_of',
            'phone',
            'fax',
            'email:email',
        ],
    ]) ?>

</div>
