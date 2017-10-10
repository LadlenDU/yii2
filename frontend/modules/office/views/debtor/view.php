<?php

use yii\helpers\Html;
//use yii\widgets\DetailView;
use kartik\tabs\TabsX;

/* @var $this yii\web\View */
/* @var $model common\models\Debtor */

$this->title = Yii::t('app', 'Данные должника');    //$model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Должники'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="debtor-view hu-pane">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (!Yii::$app->request->isAjax): ?>
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
    <?php endif; ?>

    <?php

    $tabItems = [
        [
            'label' => '<i class="glyphicon glyphicon-list-alt"></i>' . Yii::t('app', 'Общие данные'),
            'content' => $this->render('_view_common_data', ['model' => $model]),
            'active' => true,
        ],
        [
            'label' => '<i class="glyphicon glyphicon-folder-open"></i>' . Yii::t('app', 'Документооборот'),
            'content' => 'empty',
        ],
        [
            'label' => '<i class="glyphicon glyphicon-usd"></i>' . Yii::t('app', 'Финансовые данные'),
            'content' => $this->render('_view_financial_data', ['model' => $model]),
        ],
    ];

    echo TabsX::widget([
        'items' => $tabItems,
        'position' => TabsX::POS_ABOVE,
        'encodeLabels' => false,
    ]);

    ?>

</div>
