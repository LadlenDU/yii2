<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\info\Company */

$this->title = Yii::t('app', 'Создать компанию');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Компании'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="company-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
