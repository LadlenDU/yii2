<?php

/**
 * @var yii\web\View $this
 * @var $debtor common\models\Debtor
 */

use yii\helpers\Html;

$this->registerCss(<<<CSS
.subs_accruals_main_tbl {
    width: 100%;
    font-size: 8px;
}
.subs_accruals_main_tbl td,
.subs_accruals_main_tbl th {
    border: 1px solid black;
}
.subs_accruals_main_tbl th{
    text-align: center;
    vertical-align: top;
}
CSS
);

?>
<span style="font-size: 12px;font-weight:bold"><?= Yii::t('app', 'Свод начислений по лицевому счету') ?></span>
<br>
<br>
<table style="font-size: 10px">
    <tr>
        <td style="font-weight:bold;text-align:right;padding-right:2em">Номер лицевого счета</td>
        <td style="text-align:left"><?= Html::encode($debtor->LS_IKU_provider) ?></td>
    </tr>
    <tr>
        <td style="font-weight:bold;text-align:right;padding-right:2em">Адрес</td>
        <td style="text-align:left"><?= Html::encode($debtor->location->createFullAddress()) ?></td>
    </tr>
    <tr>
        <td style="font-weight:bold;text-align:right;padding-right:1em">ФИО</td>
        <td style="text-align:left"><?= Html::encode($debtor->name->createFullName()) ?></td>
    </tr>
</table>
<table class="subs_accruals_main_tbl">
    <tr>
        <th colspan="3"><?= Yii::t('app', 'Организация') ?></th>
        <th rowspan="3"><?= Yii::t('app', 'Начальный остаток') ?></th>
        <th rowspan="3"><?= Yii::t('app', 'Начислено') ?></th>
        <th rowspan="3"><?= Yii::t('app', 'Оплачено') ?></th>
        <th colspan="2"><?= Yii::t('app', 'Конечный остаток') ?></th>
        <th rowspan="3"><?= Yii::t('app', 'Сумма просроченной задолженности') ?></th>
    </tr>
    <tr>
        <td style="vertical-align: middle"><?= Yii::t('app', '№ кв.') ?></td>
        <td style="vertical-align: middle"><?= Yii::t('app', 'Лицевой счет') ?></td>
        <td style="vertical-align: middle"><?= Yii::t('app', 'Месяцев задолженности') ?></td>
    </tr>
    <tr>
        <td colspan="3"><?= Yii::t('app', 'Период взаиморасчетов') ?></td>
    </tr>
    <?

    ?>
    <tr>
        <td colspan="9" style="font-weight:bold;padding: 5em 5em 0 0">
            <?= Yii::t('app', 'Итого общая сумма задолженности <span style="font-size: 10px">{amount}</span> <span style="font-weight: normal">рублей</span>',
                ['amount' => 10000]) ?>
        </td>
    </tr>
    <tr>
        <td colspan="3" style="font-size: 10px;text-align: right;padding-right: 1em">
            <?= Yii::t('app', 'Должность') ?>
        </td>
        <td colspan="2">&nbsp;</td>
        <td colspan="4" style="font-size: 10px;text-align: left"><?= Yii::t('app', 'ФИО') ?></td>
    </tr>
    <tr>
        <td colspan="3">&nbsp</td>
        <td colspan="6" style="font-size: 10px;text-align: left"><?= Yii::t('app', 'М.П.') ?></td>
    </tr>
</table>
<br>
<br>
<br>
<br>
