<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Court */

$this->title = Yii::t('app', 'Создать суд');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Суды'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="court-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
