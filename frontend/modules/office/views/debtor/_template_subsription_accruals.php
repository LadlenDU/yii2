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

    foreach ($debtor->accruals as $accrual) {
        echo '<tr>';
        $accrualDate = date('m.Y', strtotime($accrual->accrual_date));
        //$accrualDateMonthOnly = substr($accrual->accrual_date, 0, 7);
        //TODO: может быть в теории несколько оплат - заменить one() на all()
        //$payment = \common\models\Payment::find()->where('payment_date' => $accrualDateMonthOnly)->one();
        //$payment = \common\models\Payment::find()->where(['payment_date' => $accrual->accrual_date])->one();
        $payment = $debtor->getPayments()->where(['payment_date' => $accrual->accrual_date])->one();
        $paymentAmount = $payment ? $payment->amount : '0.00';
        //TODO: проверить правильность
        $debt = (float)$accrual->accrual_recount - (float)$paymentAmount;
        echo "<td colspan='3' style='text-align:center'>$accrualDate</td>";
        echo '<td>&nbsp;</td>';
        echo "<td style='text-align:right'>$accrual->accrual_recount</td>";
        echo "<td style='text-align:right'>$paymentAmount</td>";
        echo "<td style='text-align:right'>$debt</td>";
        echo "<td style='text-align:right'>$debt</td>";
        echo "<td style='text-align:right'>$debt</td>";
        echo '</tr>';
        $totalDebt += $debt;
    }
    ?>
    <tr>
        <td colspan="9" style="font-weight:bold;padding: 5em 5em 0 0">
            <?= Yii::t('app', 'Итого общая сумма задолженности <span style="font-size: 10px">{amount}</span> <span style="font-weight: normal">рублей</span>',
                //['amount' => $debtor->debt . " ($totalDebt)"]) ?>
            ['amount' => $debtor->debt]) ?>
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
