<?php
/**
 * @var yii\web\View $this
 * @var bool $uploaded
 */

use yii\helpers\Html;

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
                <a id="debtors-bottom-menu" class="btn btn-primary btn-sm dropdown-toggle"
                   data-toggle="dropdown" href="#" aria-expanded="true"><?= Yii::t('app', 'Действия к должникам') ?> <b
                            class="caret"></b></a>
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
            <!--<span></span>-->
            <a class="btn-sm toggle-filter btn btn-primary" id="show_debtors_filter" href="javascript:void(0)">
                <i class="icon-search icon-white"></i><?= Yii::t('app', 'Поиск должников') ?>
            </a>
            <a class="hide btn-sm btn btn-grey" id="reset-debtors-filter" href="javascript:void(0)"
               style="display: none">
                <i class="fa fa-filter"></i><?= Yii::t('app', 'Сбросить фильтр') ?>
            </a>
            <!--<span></span>-->
            <a class="btn-sm toggle-filter btn btn-primary" id="load_debtors" href="javascript:void(0)"
               title="<?= Yii::t('app', 'Загрузка должников из файла') ?>">
                <i class="icon-search icon-white"></i><?= Yii::t('app', 'Загрузка должников') ?>
            </a>
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

<script>
    //$("#load_debtors").
</script>



