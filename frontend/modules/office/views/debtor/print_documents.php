<?php
/**
 * @var yii\web\View $this
 * @var array $documents
 */

$css = <<<CSS
@media print {
    .page-break {page-break-after: always;}
}
CSS;

$this->registerCss($css);

foreach ($documents as $doc) {
    echo $doc['statement']
        . '<div class="page-break"></div>'
        . $doc['full_fine_report']
        . '<div class="page-break"></div>';
}
