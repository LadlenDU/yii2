<?php

/* @var $this yii\web\View */
/* @var $searchModel common\models\DebtorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $uploadModel common\models\UploadForm */
/* @var $applicationPackage array */

use yii\helpers\Html;

//use yii\grid\GridView;
//use yii\widgets\Pjax;
use kartik\dynagrid\DynaGrid;
use yii\bootstrap\Modal;
use common\models\Debtor;
//use yii\widgets\ActiveForm;
use common\models\DebtorStatus;

$this->title = Yii::t('app', 'Работа с должниками');
$this->params['breadcrumbs'][] = $this->title;

$this->render('_index_js', ['dataProvider' => $dataProvider]);

$this->registerCss(<<<CSS
.modal-content {
    padding: 1em;
}
#dynagrid-debtors-selected-debtors {
    display: none;
    margin-left: 2em;
}
#dynagrid-debtors-selected-debtors-msg-2 {
    cursor: pointer;
    border-bottom: 1px dashed;
}
#dynagrid-debtors-change-status {
    display: none;
    cursor: pointer;
    border-bottom: 1px dashed;
    margin-right: 2em;
    float: left;
    margin-top: 0.7em;
}
CSS
);

echo $this->render('_extensions', compact('uploadModel', 'searchModel', 'showSearchPane'));//['uploadModel' => $uploadModel, 'searchModel' => $searchModel, '$showSearchPane']);

Modal::begin([
    'id' => 'pModal',
    'size' => 'modal-lg',
]);
Modal::end();

echo $this->render('_debtors_and_search', compact('searchModel', 'dataProvider', 'uploadModel', 'applicationPackage'));

?>

<!--<div class="arrow-steps clearfix">
    <div class="step"><span><? /*= Yii::t('app', 'Досудебная практика') */ ?></span></div>
    <div class="step current"><span><? /*= Yii::t('app', 'Судебная практика') */ ?></span></div>
    <div class="step"><span> <? /*= Yii::t('app', 'Исполнительное производство') */ ?></span></div>
</div>-->

<div id="statusesModal" class="modal fade" role="dialog">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog vertical-align-center">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><?= Yii::t('app', 'Смена статуса заявления') ?></h4>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="submit btn btn-success btn-small btn-sm"
                            data-dismiss="modal"><?= Yii::t('app', 'Сохранить') ?></button>
                    <button type="button" class="btn btn-danger btn-small btn-sm"
                            data-dismiss="modal"><?= Yii::t('app', 'Отменить') ?></button>
                </div>
            </div>

        </div>
    </div>
</div>

<input type="hidden" name="selected_all_total" id="debtors-selected-all-total" value="0">
