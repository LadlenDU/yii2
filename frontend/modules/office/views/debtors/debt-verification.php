<?php
/**
 * @var yii\web\View $this
 * @var common\models\UploadForm $uploadModel
 * @var bool $uploaded
 */

#use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\helpers\Enum;
#use yiister\adminlte\widgets\grid\GridView;
use yii\grid\GridView;

?>
<?php /* ?>
<?php if ($uploaded): ?>
    <p> Файл успешно загружен. Проверьте <?php echo $dir ?> . </p>
<?php endif; ?>
<?php echo Html::beginForm('', 'post', ['enctype' => 'multipart/form-data']) ?>
<?php echo Html::error($model, 'file') ?>
<?php echo Html::activeFileInput($model, 'file') ?>
<?php echo Html::submitButton('Upload') ?>
<?php Html::endForm() ?>

<?php */ ?>

<div class="grid-head">
    <div class="row">
        <div class="col-sm-6 controls-buttons">
            <div class="btn-group">
                <button id="debtors-bottom-menu" class="btn btn-primary btn-sm dropdown-toggle"
                        data-toggle="dropdown" aria-expanded="true">
                    <?= Yii::t('app', 'Действия к должникам') ?> <b class="caret"></b></button>

                <ul role="menu" class="dropdown-menu">
                    <li id="generate-notice" role="menuitem">
                        <a tabindex="-1" href="javascript:void(0)"><?= Yii::t('app', 'Проверка регистрации') ?></a>
                    </li>
                    <li id="create-lawsuit" role="menuitem">
                        <a tabindex="-1" href="javascript:void(0)"><?= Yii::t('app', 'Проверка задолженности') ?></a>
                    </li>
                    <li id="send-sms" visible="1" role="menuitem">
                        <a tabindex="-1" href="javascript:void(0)"><?= Yii::t('app', 'Расчет пошлины') ?></a>
                    </li>
                </ul>
            </div>

            <button class="btn-sm toggle-filter btn btn-primary" id="show_debtors_filter" data-toggle="collapse"
                    data-target="#search-debtors">
                <i class="icon-search icon-white"></i><?= Yii::t('app', 'Поиск должников') ?>
            </button>
            <!--<button class="hide btn-sm btn btn-grey" id="reset-debtors-filter" style="display: none">
                <i class="fa fa-filter"></i><? /*= Yii::t('app', 'Сбросить фильтр') */ ?>
            </button>-->

            <button class="btn-sm toggle-filter btn btn-primary" id="load_debtors" data-toggle="collapse"
                    data-target="#load-debtors"
                    title="<?= Yii::t('app', 'Загрузка должников из файла') ?>">
                <i class="icon-search icon-white"></i><?= Yii::t('app', 'Загрузка должников') ?>
            </button>

            <div class="clearfix"></div>
        </div>
        <div class="col-sm-6">
            <div class="pull-right" style="white-space: nowrap;"><?= Yii::t('app', 'Показывать записей') ?>
                <select id="debtors-grid_sizer" class="page-sizer" name="pageSize_Accounts">
                    <option value="10">10</option>
                    <option value="30">30</option>
                    <option value="50">50</option>
                    <option value="100" selected="selected">100</option>
                </select>
            </div>
        </div>
    </div>
</div>

<div class="row collapse" id="search-debtors">
    <div class="col-xs-12 filters">
        <div id="debtors_free_filter" class="free-filter toggle-container well-info well-sm" style="display: block;">
            <form class="debtors-filter-form form-horizontal" enctype="multipart/form-data" id="debtors-filter-form"
                  action="/debtors/debtors/debtorsList?area=debtors-index_inner_area" method="post">
                <input value="4309dd2f2fa8e357ab2115db35ee846d8e01c525" name="YII_CSRF_TOKEN" type="hidden">
                <div class="row">

                    <div class="col-md-4 col-sm-4 no-padding-right">
                        <!--<div class="lbl"><label for="DebtorsFilterForm_address">Адрес дома</label></div>-->
                        <div class="elm">
                            <select class="col-xs-12 houses_cards_id filterInput chosen-select"
                                    id="DebtorsFilterForm_address" name="DebtorsFilterForm[address]"
                                    style="display: none;">
                                <option value="" selected="selected">- Адрес дома -</option>
                                <option value="17102">Щелково г, д. 31А</option>
                            </select>
                            <div class="chosen-container chosen-container-single" style="width: 0px;" title=""
                                 id="DebtorsFilterForm_address_chosen"><a class="chosen-single" tabindex="-1"><span>- Адрес дома -</span>
                                    <div><b></b></div>
                                </a>
                                <div class="chosen-drop">
                                    <div class="chosen-search"><input autocomplete="off" type="text"></div>
                                    <ul class="chosen-results"></ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-4 no-padding-right">
                        <!--<div class="lbl"><label>Номер квартиры</label></div>-->
                        <div class="elm"><input class="form-control" placeholder="№ помещения"
                                                name="DebtorsFilterForm[flat]" id="DebtorsFilterForm_flat" type="text">
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-4">
                        <!--<div class="lbl"><label>Номер лицевого счета</label></div>-->
                        <div class="elm"><input class="form-control" placeholder="№ лицевого счета"
                                                name="DebtorsFilterForm[account]" id="DebtorsFilterForm_account"
                                                type="text"></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6 col-md-4">

                        <div class="row">
                            <div class="col-md-6 col-xs-6 no-padding-right">
                                <div class="elm"><input class="form-control" placeholder="Сумма долга от"
                                                        name="DebtorsFilterForm[sum_from]"
                                                        id="DebtorsFilterForm_sum_from" type="text"></div>
                            </div>

                            <div class="col-md-6 col-xs-6 no-padding-right">
                                <div class="elm"><input class="form-control" placeholder="Сумма долга до"
                                                        name="DebtorsFilterForm[sum_to]" id="DebtorsFilterForm_sum_to"
                                                        type="text"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-4">

                        <div class="row">
                            <div class="col-md-6 col-xs-6 no-padding-right">
                                <div class="elm"><input class="form-control" placeholder="Кол-во месяцев от"
                                                        name="DebtorsFilterForm[month_from]"
                                                        id="DebtorsFilterForm_month_from" type="text"></div>
                            </div>

                            <div class="col-md-6 col-xs-6 no-padding-right">
                                <div class="elm"><input class="form-control" placeholder="Кол-во месяцев до"
                                                        name="DebtorsFilterForm[month_to]"
                                                        id="DebtorsFilterForm_month_to" type="text"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2  col-sm-2">
                        <div class="lbl"></div>
                        <div class="elm">
                            <a class="btn-sm btn btn-primary" id="process-debtors-filter" href="javascript:void(0)"><i
                                        class="fa fa-search"></i> Найти</a></div>
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>

<div class="row collapse" id="load-debtors">
    <div class="col-xs-12">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
        <?= $form->field($uploadModel, 'excelFile')->fileInput() ?>
        <button><?= Yii::t('app', 'Отправить') ?></button>
        <?php ActiveForm::end() ?>
    </div>
</div>

<?php
#echo Enum::array2table($sheetData, false, true)
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        //'id',
        'name_mixed',
        'address',
        'locality:ntext',
        'LS_EIRC',
        'LS_IKU_provider',
        //'url:ntext',
        //'image:ntext',
        // 'created_at',
        // 'updated_at',
        ['class' => 'yii\grid\ActionColumn'],
    ],
]);
?>

<script>
    $("#load_debtors").click(function () {

    });
</script>



