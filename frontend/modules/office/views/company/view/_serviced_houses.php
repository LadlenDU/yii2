<?php

/* @var $this yii\web\View */
/* @var $model common\models\info\Company */
/* @var $filesUploadingHouses array */

use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use kartik\detail\DetailView;

$attributes = [
    [
        'attribute' => 'company_files_houses',
        'label' => Yii::t('app', 'Файлы обслуживаемых домов'),
        'value' => '',  //$filesUploading['companyFilesNames'],
        'type' => DetailView::INPUT_FILEINPUT,
        'widgetOptions' => $filesUploadingHouses['fileUploadHousesConfig'],
    ],
];

?>

<?php /*$form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); */?><!--

<?/*= $form->field($model, 'company_files_houses[]')->widget(FileInput::classname(), $filesUploadingHouses['fileUploadHousesConfig']) */?>

--><?php /*ActiveForm::end(); */?>

<?= DetailView::widget([
    'model' => $model,
    'attributes' => $attributes,
    //'mode' => DetailView::MODE_VIEW,
    'mode' => DetailView::MODE_EDIT,
    'bordered' => true,
    'striped' => false,
    'condensed' => false,
    'responsive' => true,
    'hover' => true,
    'hAlign' => 'left',
    'vAlign' => 'middle',
    /*'panel' => [
        'heading' => 'Общие данные организации',
        'type' => DetailView::TYPE_INFO,
    ],*/
    'container' => ['id' => 'company-houses-files'],
]); ?>
