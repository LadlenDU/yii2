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
.subs_accruals_main_tbl th {
    text-align: center;
    vertical-align: top;
}
.subs_accruals_main_tbl .sgkh-no-tbl-border {
    border: none;
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
        <th style="vertical-align: middle"><?= Yii::t('app', '№ кв.') ?></th>
        <th style="vertical-align: middle"><?= Yii::t('app', 'Лицевой счет') ?></th>
        <th style="vertical-align: middle"><?= Yii::t('app', 'Месяцев задолженности') ?></th>
        <th rowspan="2"><?= Yii::t('app', 'Задолженность') ?></th>
        <th rowspan="2"><?= Yii::t('app', 'Конечный остаток') ?></th>
    </tr>
    <tr>
        <th colspan="3"><?= Yii::t('app', 'Период взаиморасчетов') ?></th>
    </tr>
    <?php
    $totalDebt = 0;

    $saiItems = $debtor->getSubscriptionAccrualsInfo();

    foreach ($saiItems as $item) {
        //TODO: '0.00' - сделать как-то глобальный денежный формат для нуля денег
        echo '<tr>'
            . '<td colspan="3" style="text-align:center">' . date('m.Y', $item['accrual_date']) . '</td>'
            . '<td>' . ($item['initial_balance'] ?: '&nbsp;') . '</td>'
            . '<td style="text-align:right">' . ($item['accrual'] ?: '0.00') . '</td>'
            . '<td style="text-align:right">' . ($item['payment'] ?: '0.00') . '</td>'
            . '<td style="text-align:right">' . ($item['debt'] ?: '0.00') . '</td>'
            . '<td style="text-align:right">' . ($item['final_balance'] ?: '0.00') . '</td>'
            . '<td style="text-align:right">' . ($item['overdue_debt'] ?: '0.00') . '</td>'
            . '</tr>';
    }
    ?>
    <tr>
        <td colspan="7"
            style="font-weight:bold;padding: 5em 3em 2em 0;border-left:none;border-right:none;border-bottom:none;text-align: right">
            <?= Yii::t('app', 'Итого общая сумма задолженности <span style="font-size: 10px">{amount}</span> <span style="font-weight: normal">рублей</span>',
                //['amount' => $debtor->debt . " ($totalDebt)"])
                ['amount' => $debtor->debt]) ?>
        </td>
        <td colspan="2" style="border-left:none;border-right:none;border-bottom:none">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="3" class="sgkh-no-tbl-border" style="font-size: 10px;text-align: right;padding-right: 1em">
            <?= Yii::t('app', 'Генеральный директор') ?>
        </td>
        <td colspan="2" class="sgkh-no-tbl-border">&nbsp;</td>
        <td colspan="4" class="sgkh-no-tbl-border"
            style="font-size: 10px;text-align: left"><?= Yii::t('app', Yii::$app->user->identity->userInfo->primaryCompany->cEO->createShortName()) ?></td>
    </tr>
    <tr>
        <td colspan="3" class="sgkh-no-tbl-border">&nbsp</td>
        <td colspan="6" class="sgkh-no-tbl-border"
            style="font-size: 10px;text-align: left"><?= Yii::t('app', 'М.П.') ?></td>
    </tr>
</table>
<br>
<br>
<br>
<br>
<br>
<br>
