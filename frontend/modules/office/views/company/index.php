<?php

use yii\helpers\{
    Html, Url
};
//use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
//use common\models\Location;
use common\models\info\Company;

/* @var $this yii\web\View */
/* @var $searchModel common\models\info\CompanySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $primaryCompanyId int */

$this->title = Yii::t('app', 'Организации');
$this->params['breadcrumbs'][] = $this->title;

$setPrimaryCompanyLink = json_encode(Url::to('/office/company/set-primary'));

$js = <<<JS
jQuery(".set_default_company").click(function(e) {
    e.preventDefault();
    var id = $("input[name=primaryCompany]:checked").val();
    $.post($setPrimaryCompanyLink, {primary_company_id:id}).done(function(msg) {
        alert(msg);
    });
    return false;
});
JS;

$this->registerJs($js);

?>
<div class="company-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Создать организацию'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Организация по умолчанию'), ['create'], ['class' => 'btn btn-success set_default_company']) ?>
    </p>
    <?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            //'id',
            [
                'class' => 'yii\grid\RadioButtonColumn',
                'name' => 'primaryCompany',
                'radioOptions' => function ($model) use ($primaryCompanyId) {
                    return [
                        'value' => $model['id'],
                        'checked' => $model['id'] == $primaryCompanyId,
                    ];
                }
            ],
            'full_name',
            'short_name',
            [
                'attribute' => 'legal_address_location_id',
                'format' => 'text',
                'value' => function (Company $model) {
                    return $model->legalAddressLocation ? $model->legalAddressLocation->createFullAddress() : Yii::$app->formatter->nullDisplay;
                },
            ],
            [
                'attribute' => 'actual_address_location_id',
                'format' => 'text',
                'value' => function (Company $model) {
                    return $model->actualAddressLocation ? $model->actualAddressLocation->createFullAddress() : Yii::$app->formatter->nullDisplay;
                },
            ],
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
