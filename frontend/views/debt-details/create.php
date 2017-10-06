<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\DebtDetails */

$this->title = Yii::t('app', 'Создать детали задолженности');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Детали задолженности'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="debt-details-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
