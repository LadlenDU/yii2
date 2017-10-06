<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\DebtorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Должники');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="debtor-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Создать должника'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'first_name',
            'second_name',
            'patronymic',
            'name_mixed',
            // 'address',
            // 'region',
            // 'regionId',
            // 'district',
            // 'districtId',
            // 'city',
            // 'cityId',
            // 'street',
            // 'streetId',
            // 'building',
            // 'buildingId',
            // 'appartment',
            // 'phone',
            // 'LS_EIRC',
            // 'LS_IKU_provider',
            // 'IKU',
            // 'space_common',
            // 'space_living',
            // 'privatized',
            // 'general_manager_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
