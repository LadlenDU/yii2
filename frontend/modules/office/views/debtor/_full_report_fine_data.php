<?php

/* @var $this yii\web\View */
/* @var $html string */
/* @var $debtorId int */
/* @var $debtorLS string */
/* @var $debtorName string */
/* @var $debtorAddress string */

?>

<table style="width: 100%;margin:1em 0;">
    <tr>
        <th colspan="2"><?= Yii::t('app','Расчёт пени по коммунальным платежам') ?></th>
    </tr>
    <tr>
        <td><?= Yii::t('app','№ ЛС') ?></td>
        <td><?= $debtorLS ?></td>
    </tr>
    <tr>
        <td><?= Yii::t('app','ФИО') ?></td>
        <td><?= $debtorName ?></td>
    </tr>
    <tr>
        <td><?= Yii::t('app','Адрес') ?></td>
        <td><?= $debtorAddress ?></td>
    </tr>
</table>

<?= $html ?>
