<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Accrual */

$this->title = Yii::t('app', 'Создать начисление');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Начисления'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="accrual-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
