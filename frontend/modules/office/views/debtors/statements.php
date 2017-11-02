<?php
/**
 * @var yii\web\View $this
 * @var array $debts
 */

//use yii\helpers\Html;

$css = <<<CSS
@media print {
    .page-break {page-break-after: always;}
}
CSS;

$this->registerCss($css);

foreach ($debts as $d) {
    echo $this->render('statement', $d)
        . '<div class="page-break" style="page-break-after: always;"></div>';
}

