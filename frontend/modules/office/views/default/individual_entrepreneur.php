<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use yii\helpers\Url;

//use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\info\IndividualEntrepreneur */
/* @var $form ActiveForm */

//TODO: title из БД

#labels = $model->attributeLabels();

$userFiles = $model->userInfo->userFiles;

$filesPluginOptions = [
    'initialPreview' => [],
    'initialPreviewConfig' => [],
];

foreach ($userFiles as $file) {
    //TODO: проверить (реализовать) секьюрность (чтобы чужие файлы не открывались)
    $filesPluginOptions['initialPreview'][] = Url::to(['/office/user-file', 'uInfoId' => $model->userInfo->user_id, 'fId' => $file->id]);
    $filesPluginOptions['initialPreviewConfig'][] = [
        'caption' => $file->name,
        //'size' => '873727'
    ];
}
?>
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
        'pluginOptions' => [
            'initialPreview' => $filesPluginOptions['initialPreview'],/*[
                "http://upload.wikimedia.org/wikipedia/commons/thumb/e/e1/FullMoon2010.jpg/631px-FullMoon2010.jpg",
                "http://upload.wikimedia.org/wikipedia/commons/thumb/6/6f/Earth_Eastern_Hemisphere.jpg/600px-Earth_Eastern_Hemisphere.jpg"
            ],*/
            'initialPreviewAsData' => true,
            'initialCaption' => Yii::t('app', 'Дополнительные файлы'),
            'initialPreviewConfig' => $filesPluginOptions['initialPreviewConfig'],/*[
                ['caption' => 'Moon.jpg', 'size' => '873727'],
                ['caption' => 'Earth.jpg', 'size' => '1287883'],
            ],*/
            'overwriteInitial' => false,
        ]
    ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div><!-- individual_entrepreneur -->
