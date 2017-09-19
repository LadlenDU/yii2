<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\CourtSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Суды');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="court-index">

    <!--<h1><?/*= Html::encode($this->title) */?></h1>-->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Создать суд'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => ['style' => 'overflow-x:auto'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'address',
            'region',
            //'regionId',
            'district',
            //'districtId',
            'city',
            // 'cityId',
            'street',
            // 'streetId',
            'building',
            // 'buildingId',
            'phone',
            'name_of_payee',
            //'BIC',
            //'beneficiary_account_number',
            //'INN',
            //'KPP',
            //'OKTMO',
            //'beneficiary_bank_name',
            //'KBK',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
