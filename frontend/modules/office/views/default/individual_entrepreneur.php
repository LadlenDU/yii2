<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use yii\helpers\Url;
use yii\widgets\Pjax;
use kartik\grid\GridView;

//use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\info\IndividualEntrepreneur */
/* @var $form ActiveForm */
/* @var $companies array */

//TODO: title из БД

#labels = $model->attributeLabels();

$userFiles = $model->userInfo->userFiles;

//TODO: поместить в модель
$filesPluginOptions = [
    'initialPreview' => [],
    'initialPreviewConfig' => [],
];

foreach ($userFiles as $key => $file) {
    //TODO: проверить (реализовать) секьюрность (чтобы чужие файлы не открывались)
    $filesPluginOptions['initialPreview'][] = Url::to(['/office/user-file', 'id' => $file->id]);
    $filesPluginOptions['initialPreviewConfig'][] = [
        'key' => $key,
        //TODO: pdf - может быть другой ???
        //'type' => 'pdf',
        'filetype' => $file->mime_type,
        'caption' => $file->name,
        'size' => strlen($file->content),
        'url' => Url::to(['/office/user-file', 'id' => $file->id, 'action' => 'remove']),
        'downloadUrl' => Url::to(['/office/user-file', 'id' => $file->id, 'action' => 'download']),
    ];
}
?>

<div class="company-index">

    <label class="control-label"><?= Html::encode(Yii::t('app', 'Список компаний')) ?></label>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Создать компанию'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $companies['dataProvider'],
        'filterModel' => $companies['searchModel'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
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

<div class="individual_entrepreneur">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

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
    <?= $form->field($model, 'OGRN') ?>
    <?= $form->field($model, 'INN') ?>
    <?= $form->field($model, 'BIC') ?>
    <?= $form->field($model, 'checking_account_num') ?>
    <? /*= $form->field($model->userInfo->location, 'district') */ ?>

    <? /*= $form->field($model, 'user_info_document_1')->fileInput() */ ?><!--
    --><? /*= $form->field($model, 'user_info_document_2')->fileInput() */ ?>

    <?= //$form->field($model->userInfo->userFiles, 'id')->widget(FileInput::classname(), [
    $form->field($model->userInfo, 'user_files[]')->widget(FileInput::classname(), [
        'options' => [
            'accept' => 'application/pdf',
            'multiple' => true,
        ],
        //TODO: в модель
        'pluginOptions' => [
            'showRemove' => false,
            'initialPreview' => $filesPluginOptions['initialPreview'],
            'initialPreviewAsData' => true,
            'initialPreviewFileType' => 'pdf',
            'initialCaption' => Yii::t('app', 'Дополнительные файлы'),
            'initialPreviewConfig' => $filesPluginOptions['initialPreviewConfig'],
            'overwriteInitial' => false,
        ],
        'pluginEvents' => [
            'filebeforedelete' => 'function() {
                var aborted = !window.confirm(' . json_encode(Yii::t('app', 'Вы уверены что хотите удалить элемент?')) . ');
                return aborted;
            }',
        ],
    ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div><!-- individual_entrepreneur -->
