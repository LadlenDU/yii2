<?php
/**
 * @var yii\web\View $this
 * @var common\models\UploadForm $uploadModel
 * @var $searchModel common\models\DebtorSearch
 * @var $showSearchPane bool
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\file\FileInput;
use wbraganca\tagsinput\TagsinputWidget;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

$this->registerCss(<<<CSS
.bootstrap-tagsinput {
  width: 100% !important;
}
CSS
);

$applicationPackageToTheContracts = ArrayHelper::map(\Yii::$app->user->identity->applicationPackageToTheContracts, 'id', 'number');

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

                <button class="btn-sm toggle-filter btn btn-primary" id="search_debtors" data-toggle="collapse"
                        data-target="#search-debtors">
                    <i class="icon-search icon-white"></i><?= Yii::t('app', 'Поиск') ?>
                </button>

                <button class="btn-sm toggle-filter btn btn-primary" id="load_debtors" data-toggle="collapse"
                        data-target="#load-debtors"
                        title="<?= Yii::t('app', 'Загрузка должников из файла') ?>">
                    <i class="icon-search icon-white"></i><?= Yii::t('app', 'Загрузка должников') ?>
                </button>

                <!--<button class="btn-sm btn btn-primary" id="print_invoices"
                    title="<?/*= Yii::t('app', 'Распечатка бланков выбранных должников') */ ?>">
                <i class="icon-search icon-white"></i><?/*= Yii::t('app', 'Распечатка бланков') */ ?>
            </button>-->

                <button class="btn-sm btn btn-primary" id="print_statements"
                        title="<?= Yii::t('app', 'Распечатка заявлений в суд на выбранных должников') ?>">
                    <i class="icon-search icon-white"></i><?= Yii::t('app', 'Распечатка заявлений') ?>
                </button>

                <!--<button class="btn-sm btn btn-primary" id="print_documents"
                    title="<?/*= Yii::t('app', 'Распечатка документов выбранных должников') */ ?>">
                <i class="icon-search icon-white"></i><?/*= Yii::t('app', 'Распечатка документов') */ ?>
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

    <div class="collapse<?= $showSearchPane ? ' in' : '' ?>" id="search-debtors">
        <?php $form = ActiveForm::begin([
            'action' => ['index', 'search' => '1'],
            'fieldConfig' => [
                'enableLabel' => false,
            ],
        ]); ?>

        <div class="row">
            <div class="col-md-4">
                <?= $form->field($searchModel, 'location_street')->textInput(['placeholder' => Yii::t('app', 'Адрес дома')]) ?>
            </div>
            <div class="col-md-4">
                <?/*= $form->field($searchModel, 'LS_IKU_provider')->textInput(['placeholder' => Yii::t('app', 'Номер лицевого счета')]) */ ?>
                <?= $form->field($searchModel, 'LS_IKU_provider')->widget(TagsinputWidget::classname(), [
                    'clientOptions' => [
                        'trimValue' => true,
                        'allowDuplicates' => false,
                        'delimiter' => ' ',
                    ],
                    'options' => [
                        'placeholder' => Yii::t('app', '№ ЛС'),
                    ],
                ]) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($searchModel, 'status_status')->dropDownList(['' => Yii::t('app', '- Любой статус -')] + \common\models\DebtorStatus::STATUSES, ['id' => 'debtorstatus-status-search']); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <?= $form->field($searchModel, 'location_building')->textInput(['placeholder' => Yii::t('app', '№ помещения')]) ?>
            </div>
            <div class="col-md-2">
                <?= $form->field($searchModel, 'claim_sum_from')->textInput(['placeholder' => Yii::t('app', 'Цена иска от')]) ?>
            </div>
            <div class="col-md-2">
                <?= $form->field($searchModel, 'claim_sum_to')->textInput(['placeholder' => Yii::t('app', 'Цена иска до')]) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($searchModel, 'application_package')->dropDownList(['' => Yii::t('app', '- Любой номер приложения -')] + $applicationPackageToTheContracts) ?>
            </div>
        </div>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Искать'), ['class' => 'btn btn-primary']) ?>
            <?= Html::resetButton(Yii::t('app', 'Сбросить'), ['class' => 'btn btn-default']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

    <div class="row collapse" id="load-debtors">
        <!--<div class="col-xs-12">
            <?php
        /*            $form = ActiveForm::begin([
                        'options' => [
                            'enctype' => 'multipart/form-data',
                        ],
                    ]);
                    echo Html::hiddenInput('action', 'upload_debtors_excel_type_1');
                    echo $form->field($uploadModel, 'debtorsExcelType1')->widget(FileInput::classname(), $uploadModel->fileUploadConfig('excel'));
                    ActiveForm::end();
                    */ ?>
        </div>-->
        <div class="col-xs-12">
            <?php
            $form = ActiveForm::begin([
                'options' => [
                    'enctype' => 'multipart/form-data',
                ],
            ]);
            //echo $form->field($uploadModel, 'action')->hiddenInput(['value' => 'upload_debtors_excel']);
            echo Html::hiddenInput('action', 'upload_debtors_excel_a_user');
            echo $form->field($uploadModel, 'excelFileForAUser')->widget(FileInput::classname(), $uploadModel->fileUploadConfig('excel'));
            ActiveForm::end();
            ?>
        </div>
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
$lowBalance = json_encode(Yii::t('app', 'Недостаточно средств.'));
$pdfUrl = json_encode(Url::to('/office/debtor/print-documents/?', true));
$script = <<<JS
    function getDebtorsSelected()
    {
        var keys = $('#dynagrid-debtors-options').yiiGridView('getSelectedRows');
        if (!keys.length) {
            alert($noDebtorsSelectedTxt);
            return false;
        }
        return keys;
    }

    $("#print_invoices").click(function () {
        var keys = getDebtorsSelected();
        if (keys) {
            var url = '/office/debtors/invoice-prev/?' + $.param({debtorIds:keys});
            window.open(url, '_blank');
        }
    });

    $("#print_statements").click(function (e) {
        e.preventDefault();
        var keys = getDebtorsSelected();
        if (!keys) {
            return false;
        }
                
        var embedHtml = '<html><head><style>body{margin:0;padding:0;}html,body{width:100%;height:100%}</style></head><body>' 
            + '<embed type="application/pdf" src="' + $pdfUrl + $.param({debtorIds:keys}) + '" id="pdfDocument" width="100%" height="100%" />'
            + '</body></html>';
        
        //window.location.href = $pdfUrl + $.param({debtorIds:keys});
        var statementWnd = window.open($pdfUrl + $.param({debtorIds:keys}), '_blank');
        return false;
        
        //TODO: false вместо '' ??
        /*var statementWnd = window.open('', '_blank');
        statementWnd.addEventListener('load', function() {
                //TODO: костыль - подумать что с ним делать
                setTimeout(function() {
                        statementWnd.focus();
                        statementWnd.print();
                    },
                    5000
                );
            }, false);
        statementWnd.document.open();
        statementWnd.document.write(embedHtml);
        statementWnd.document.close();*/
        /*statementWnd[statementWnd.addEventListener ? 'addEventListener' : 'attachEvent'](
            (statementWnd.attachEvent ? 'on' : '') + 'load', function() {
                alert(1);
                statementWnd.focus();
                statementWnd.print();
            }, false
        );*/
        //statementWnd.focus();
        //statementWnd.print();
        //statementWnd.close();
        return false;
        
        $("body").css("cursor", "progress");
        //var url = '/office/debtors/statements/?' + $.param({debtorIds:keys});
        //var url = '/office/debtors/statements';
        var url = '/office/debtor/print-documents';
        $.post(url, {debtorIds:keys}, function(html) {
            if (html == 'low_balance') {
                alert($lowBalance);
            } else {
                //var statementWnd = window.open(url, '_blank');
                var statementWnd = window.open('', '_blank');
                statementWnd.document.write(html);
                statementWnd.document.close();
                statementWnd.focus();
                //statementWnd.print();
                //statementWnd.close();
            }
        }, 'html').fail(function() {
            alert($printErrorTxt);
        }).done(function() {
            $("body").css("cursor", "default");
        });
    });
    $("#print_documents").click(function () {
        var keys = getDebtorsSelected();
        if (keys) {
            var url = '/office/debtors/documents/?' + $.param({debtorIds:keys});
            window.open(url, '_blank');
        }
    });

JS;
$this->registerJs($script, yii\web\View::POS_READY, 'debt-verification');
