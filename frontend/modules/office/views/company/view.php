<?php

/* @var $this yii\web\View */
/* @var $model common\models\info\Company */
/* @var $fileUploadConfig array */

use yii\helpers\Html;
use kartik\tabs\TabsX;

$this->title = $model->full_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Организации'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="company-view hu-pane">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php

    $tabItems = [
        [
            'label' => '<i class="glyphicon glyphicon-list-alt"></i>' . Yii::t('app', 'Общие данные'),
            'content' => $this->render('view/_common_data', ['model' => $model, 'fileUploadConfig' => $fileUploadConfig]),
            'active' => true,
        ],
        [
            'label' => '<i class="glyphicon glyphicon-folder-open"></i>' . Yii::t('app', 'Обслуживаемые дома'),
            'content' => 'empty',
        ],
        [
            'label' => '<i class="glyphicon glyphicon-usd"></i>' . Yii::t('app', 'Отделы и должности'),
            'content' => 'empty',
        ],
        [
            'label' => '<i class="glyphicon glyphicon-usd"></i>' . Yii::t('app', 'Сотрудники'),
            'content' => 'empty',
        ],
    ];

    echo TabsX::widget([
        'items' => $tabItems,
        'position' => TabsX::POS_ABOVE,
        'encodeLabels' => false,
    ]);

    ?>

    <p style="text-align: right">
        <?/*= Html::a(Yii::t('app', 'Обновить'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) */?>
        <?= Html::a(Yii::t('app', 'Удалить организацию'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Вы уверены что хотите удалить текущую организацию?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

</div>
