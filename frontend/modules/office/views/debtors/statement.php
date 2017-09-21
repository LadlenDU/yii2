<?php
/**
 * @var yii\web\View $this
 * @var common\models\DebtDetails $debtDetails
 * @var common\models\Court $court
 */

use yii\helpers\Html;

?>

<table style="width: 95%">
    <tr>
        <td style="text-align: center">
            <strong><?= Html::encode($court->name) ?></strong><br>
            ИНН <?= Html::encode($court->INN) ?><br>
            ОГРН <?= Html::encode($court->OKTMO) ?><br>
            ***<br>
            адрес: <?= Html::encode($court->getFullAddress()) ?>
        </td>
        <td>
            <table style="float: right">
                <tr>
                    <td>&nbsp;</td>
                    <td style="text-align: left">
                        <strong>
                            Мировому судье судебного участка № 281
                            <?= Html::encode("$court->district, $court->region") ?>
                        </strong>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right;font-weight: bold;text-decoration: underline">Взыскатель</td>
                    <td style="text-align: left">
                        <strong><?= Html::encode($court->name) ?></strong><br>
                        <?= Html::encode($court->getFullAddress()) ?>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right;text-decoration: underline">Должник</td>
                    <td style="text-align: left">
                        <strong><?= Html::encode($debtDetails->debtor->getFIOName()) ?></strong><br>
                        <?= Html::encode($debtDetails->debtor->getFullAddress()) ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<br>
<br>

№ _______ от ______________<br><br>

<div style="text-align: center;width: 60%;font-weight: bold;margin: auto">Заявление о выдаче судебного приказа
    <br>о взыскании задолженности за жилищно-коммунальные услуги
</div>

