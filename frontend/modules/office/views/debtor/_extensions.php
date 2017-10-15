<?php
/**
 * @var yii\web\View $this
 * @var common\models\UploadForm $uploadModel
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

?>
<div class="arrow-steps clearfix">
    <div class="step"><span><?= Yii::t('app', 'Досудебная практика') ?></span></div>
    <div class="step current"><span><?= Yii::t('app', 'Судебная практика') ?></span></div>
    <div class="step"><span> <?= Yii::t('app', 'Исполнительное производство') ?></span></div>
</div>

<br>

<div class="grid-head">
    <div class="row">
        <div class="col-sm-12 controls-buttons">
            <!--<div class="btn-group">
                <button id="debtors-bottom-menu" class="btn btn-primary btn-sm dropdown-toggle"
                        data-toggle="dropdown" aria-expanded="true">
                    <? /*= Yii::t('app', 'Действия к должникам') */ ?> <b class="caret"></b></button>

                <ul role="menu" class="dropdown-menu">
                    <li id="generate-notice" role="menuitem">
                        <a tabindex="-1" href="javascript:void(0)"><? /*= Yii::t('app', 'Проверка регистрации') */ ?></a>
                    </li>
                    <li id="create-lawsuit" role="menuitem">
                        <a tabindex="-1" href="javascript:void(0)"><? /*= Yii::t('app', 'Проверка задолженности') */ ?></a>
                    </li>
                    <li id="send-sms" visible="1" role="menuitem">
                        <a tabindex="-1" href="javascript:void(0)"><? /*= Yii::t('app', 'Расчет пошлины') */ ?></a>
                    </li>
                </ul>
            </div>-->

            <!--<button class="btn-sm toggle-filter btn btn-primary" id="show_debtors_filter" data-toggle="collapse"
                    data-target="#search-debtors">
                <i class="icon-search icon-white"></i><? /*= Yii::t('app', 'Поиск должников') */ ?>
            </button>-->
            <!--<button class="hide btn-sm btn btn-grey" id="reset-debtors-filter" style="display: none">
                <i class="fa fa-filter"></i><? /*= Yii::t('app', 'Сбросить фильтр') */ ?>
            </button>-->

            <button class="btn-sm toggle-filter btn btn-primary" id="load_debtors" data-toggle="collapse"
                    data-target="#load-debtors"
                    title="<?= Yii::t('app', 'Загрузка должников из файла') ?>">
                <i class="icon-search icon-white"></i><?= Yii::t('app', 'Загрузка должников') ?>
            </button>

            <button class="btn-sm btn btn-primary" id="print_invoices"
                    title="<?= Yii::t('app', 'Распечатка бланков выбранных должников') ?>">
                <i class="icon-search icon-white"></i><?= Yii::t('app', 'Распечатка бланков') ?>
            </button>

            <button class="btn-sm btn btn-primary" id="print_statements"
                    title="<?= Yii::t('app', 'Распечатка заявлений в суд на выбранных должников') ?>">
                <i class="icon-search icon-white"></i><?= Yii::t('app', 'Распечатка заявлений') ?>
            </button>

            <!--<button class="btn-sm btn btn-primary" id="print_documents"
                    title="<?/*= Yii::t('app', 'Распечатка документов выбранных должников') */?>">
                <i class="icon-search icon-white"></i><?/*= Yii::t('app', 'Распечатка документов') */?>
            </button>-->

            <div class="clearfix"></div>
        </div>
        <!--<div class="col-sm-6">
            <div class="pull-right" style="white-space: nowrap;"><? /*= Yii::t('app', 'Показывать записей') */ ?>
                <select id="debtors-grid_sizer" class="page-sizer" name="pageSize_Accounts">
                    <option value="10">10</option>
                    <option value="30">30</option>
                    <option value="50">50</option>
                    <option value="100" selected="selected">100</option>
                </select>
            </div>
        </div>-->
    </div>
</div>
<br>

<div class="row collapse" id="load-debtors">
    <!--<div class="col-xs-12">
        <?php
/*        $form = ActiveForm::begin([
            'options' => [
                'enctype' => 'multipart/form-data',
            ],
        ]);
        //echo $form->field($uploadModel, 'action')->hiddenInput(['value' => 'upload_debtors_excel']);
        echo Html::hiddenInput('action', 'upload_debtors_excel');
        echo $form->field($uploadModel, 'excelFile')->widget(FileInput::classname(), $uploadModel->fileUploadConfig('excel'));
        ActiveForm::end();
        */?>
    </div>-->
    <div class="col-xs-12">
        <?php
        $form = ActiveForm::begin([
            /*'action' => [
                '/office/debtors/debt-verification',
                'action' => 'upload_debtors_csv',
            ],*/
            'options' => [
                'enctype' => 'multipart/form-data',
            ],
        ]);
        //echo $form->field($uploadModel, 'action')->hiddenInput(['value' => 'upload_debtors_csv']);
        echo Html::hiddenInput('action', 'upload_debtors_csv');
        echo $form->field($uploadModel, 'csvFile')->widget(FileInput::classname(), $uploadModel->fileUploadConfig('csv'));
        ActiveForm::end();
        ?>
    </div>
</div>

<?php
$printErrorTxt = json_encode(Yii::t('app', 'Ошибка печати!'));
$noDebtorsSelectedTxt = json_encode(Yii::t('app', 'Выберите пожалуйста должников.'));
$script = <<<JS
    $("#print_invoices").click(function () {
        var keys = $('#dynagrid-debts-options').yiiGridView('getSelectedRows');
        if (!keys.length) {
            alert($noDebtorsSelectedTxt);
            return;
        }
        var url = '/office/debtors/invoice-prev/?' + $.param({debtorIds:keys});
        window.open(url, '_blank');
    });
    $("#print_statements").click(function () {
        var keys = $('#dynagrid-debts-options').yiiGridView('getSelectedRows');
        if (!keys.length) {
            alert($noDebtorsSelectedTxt);
            return;
        }
        //var url = '/office/debtors/statements/?' + $.param({debtorIds:keys});
        var url = '/office/debtors/statements';
        $.post(url, {debtorIds:keys}, function(html) {
            //var statementWnd = window.open(url, '_blank');
            var statementWnd = window.open('', '_blank');
            statementWnd.document.write(html);
            statementWnd.document.close();
            statementWnd.focus();
            statementWnd.print();
            statementWnd.close();
        }, 'html').fail(function() {
            alert($printErrorTxt);
        });
    });
    $("#print_documents").click(function () {
        var keys = $('#dynagrid-debts-options').yiiGridView('getSelectedRows');
        if (!keys.length) {
            alert($noDebtorsSelectedTxt);
            return;
        }
        var url = '/office/debtors/documents/?' + $.param({debtorIds:keys});
        window.open(url, '_blank');
    });

JS;
$this->registerJs($script, yii\web\View::POS_READY, 'debt-verification');
