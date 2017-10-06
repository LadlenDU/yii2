<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Debtor */

$this->title = Yii::t('app', 'Создать карточку должника');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Должники'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="debtor-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
