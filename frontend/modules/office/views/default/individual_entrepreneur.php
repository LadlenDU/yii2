<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use yii\helpers\Url;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

//use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\info\IndividualEntrepreneur */
/* @var $form ActiveForm */
/* @var $companies array */
/* @var $fileUploadConfig array */

//TODO: title из БД

#labels = $model->attributeLabels();

//$fileUploadConfig = $model->userInfo->fileUploadConfig();
//$fuHelper = new \common\helpers\FileUploadHelper('');
//$fileUploadConfig = $model->userInfo->fileUploadConfig();

?>

<!--<div class="company-index">

    <label class="control-label"><? /*= Html::encode(Yii::t('app', 'Список организаций')) */ ?></label>
    <?php /*// echo $this->render('_search', ['model' => $searchModel]); */ ?>

    <p>
        <? /*= Html::a(Yii::t('app', 'Создать организацию'), ['/office/company/create'], ['class' => 'btn btn-success']) */ ?>
    </p>
    <?php /*Pjax::begin(); */ ?>    <? /*= GridView::widget([
        'dataProvider' => $companies['dataProvider'],
        'filterModel' => $companies['searchModel'],
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            //'id',
            'full_name',
            'short_name',
            'legal_address_location_id',
            'actual_address_location_id',
            'INN',
            'KPP',
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

            [
                'class' => 'yii\grid\ActionColumn',
                'urlCreator' => function ($action, $model, $key, $index) {
                    $url = Url::to(["/office/company/$action", 'id' => $model->id]);
                    return $url;
                },
            ],
        ],
    ]); */ ?>
    <?php /*Pjax::end(); */ ?></div>-->

<?php

/*$companies = $model->userInfo->companies;
foreach ($companies as $comp) {
    echo '$comp';
}*/

#$authors = Author::find()->all();
// формируем массив, с ключем равным полю 'id' и значением равным полю 'name'
#$items = ArrayHelper::map($model->userInfo->companies, 'id', 'full_name');
#echo $form->field($model->userInfo->companies, 'full_name')->dropDownList($items);

$companies = $model->userInfo->companies;

?>

<div class="individual_entrepreneur">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?php
    $items = ['' => Yii::t('app', 'Не выбрано')] + ArrayHelper::map($model->userInfo->companies, 'id', 'full_name');
    echo $form->field(Yii::$app->user->identity->userInfo, 'primary_company')->dropDownList($items, ['id' => 'primary_company']);
    ?>

    <? /*= $form->field($model, 'user_info_id') */ ?>
    <? /*= $form->field($model, 'birthday') */ ?>
    <?= $form->field($model, 'full_name') ?>
    <?php
    /*echo $form->field($model, 'birthday')->widget(DatePicker::classname(), [
        'options' => ['placeholder' => Yii::t('app', 'Введите дату рождения')],
        'value' => date('d.m.Y', strtotime($model->birthday)),
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'dd.mm.yyyy',
        ]
    ]);
    */ ?>
    <?/*= $form->field($model, 'OGRN') */?>
    <?= $form->field($model, 'INN') ?>
    <?= $form->field($model, 'BIC') ?>
    <?= $form->field($model, 'checking_account_num') ?>
    <? /*= $form->field($model->userInfo->location, 'district') */ ?>

    <? /*= $form->field($model, 'user_info_document_1')->fileInput() */ ?><!--
    --><? /*= $form->field($model, 'user_info_document_2')->fileInput() */ ?>

    <?= //$form->field($model->userInfo->userFiles, 'id')->widget(FileInput::classname(), [
    $form->field($model->userInfo, 'user_files[]')->widget(FileInput::classname(), $fileUploadConfig);
    ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div><!-- individual_entrepreneur -->
