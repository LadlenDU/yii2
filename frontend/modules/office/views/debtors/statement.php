<?php
/**
* @var yii\web\View $this
* @var common\models\DebtDetails $debtDetails
* @var common\models\Court $court
*/

use yii\helpers\Html;

?>

<table>
    <tr>
        <td style="text-align: center">
            <strong><?= Html::encode($court->name) ?></strong><br>
            ИНН <?= Html::encode($court->INN) ?><br>
            ОГРН <?= Html::encode($court->OKTMO) ?><br>
            ***<br>
            адрес: <?= Html::encode($court->getFullAddress()) ?>
        </td>
    </tr>
    <tr>
        <td>

        </td>
    </tr>
</table>
