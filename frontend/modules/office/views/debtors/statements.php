<?php
/**
 * @var yii\web\View $this
 * @var array $debts
 * @var common\models\UserInfo $userInfo
 */

use yii\helpers\Html;

$css = <<<CSS
@media print {
    .page-break {page-break-after: always;}
}
CSS;

$this->registerCss($css);

?>

<?php
    foreach ($debts as $d) {
        echo $this->render('statement', $d + ['userInfo' => $userInfo]);
    }
?>

<div class="page-break"></div>
