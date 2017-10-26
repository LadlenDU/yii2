<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\info\CompanySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $primaryCompanyId int */

$this->title = Yii::t('app', 'Организации');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="company-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Создать организацию'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Организация по умолчанию'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            //'id',
            [
                'class' => 'yii\grid\RadioButtonColumn',
                'radioOptions' => function ($model) use($primaryCompanyId) {
                    return [
                        'value' => $model['id'],
                        'checked' => $model['id'] == $primaryCompanyId,
                    ];
                }
            ],
            'full_name',
            'short_name',
            'legal_address_location_id',
            'actual_address_location_id',
            // 'INN',
            // 'KPP',
            // 'BIK',
            // 'OGRN',
            // 'checking_account',
            // 'correspondent_account',
            // 'full_bank_name',
            // 'CEO',
            // 'operates_on_the_basis_of',
            // 'phone',
            // 'fax',
            // 'email:email',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
