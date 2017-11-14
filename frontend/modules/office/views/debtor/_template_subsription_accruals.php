<?php

/**
 * @var yii\web\View $this
 * @var $debtor common\models\Debtor
 */

use yii\helpers\Html;

?>
<span style="font-size: 12px;font-weight:bold"><?= Yii::t('app', 'Свод начислений по лицевому счету') ?></span>
<br>
<br>
<table style="font-size: 10px">
    <tr>
        <td style="font-weight:bold;text-align:right">Номер лицевого счета</td>
        <td style="text-align:left"><?= Html::encode($debtor->LS_IKU_provider) ?></td>
    </tr>
    <tr>
        <td style="font-weight:bold;text-align:right">Адрес</td>
        <td style="text-align:left"><?= Html::encode($debtor->location->createFullAddress()) ?></td>
    </tr>
    <tr>
        <td style="font-weight:bold;text-align:right">ФИО</td>
        <td style="text-align:left"><?= Html::encode($debtor->name->createFullName()) ?></td>
    </tr>
</table>
<table style="width: 100%;font-size: 8px">
    <tr>
        <td colspan="3"><?= Yii::t('app', 'Организация')?></td>
        <td rowspan="3"><?= Yii::t('app', 'Начальный остаток')?></td>
        <td rowspan="3"><?= Yii::t('app', 'Начислено')?></td>
        <td rowspan="3"><?= Yii::t('app', 'Оплачено')?></td>
        <td colspan="2"><?= Yii::t('app', 'Конечный остаток')?></td>
        <td rowspan="3"><?= Yii::t('app', 'Сумма просроченной задолженности')?></td>
    </tr>
    <tr>
        <td><?= Yii::t('app', '№ кв.')?></td>
        <td><?= Yii::t('app', 'Лицевой счет')?></td>
        <td><?= Yii::t('app', 'Месяцев задолженности')?></td>
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
    </tr>€
</table>
<br>
<br>
<br>
<br>
