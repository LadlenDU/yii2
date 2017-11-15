<?php

/**
 * @var yii\web\View $this
 * @var $debtors [] common\models\Debtor
 */

$this->registerCss(<<<CSS
@media print {
    .page-break {page-break-after: always;}
}
CSS
);

$count = count($debtors);
$i = 0;
foreach ($debtors as $debtor) {
    $html = $this->render('_template_subsription_accruals', ['debtor' => $debtor]);
    if (++$i != $count) {
        $html .= '<div class="page-break" style="page-break-after: always"></div>';
    }
    echo $html;
}
