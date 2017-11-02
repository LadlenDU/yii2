<?php
/**
 * @var yii\web\View $this
 * @var array $documents
 */

$this->context->layout = '@frontend/modules/office/views/layouts/print_fine';

$css = <<<CSS
@media print {
    .page-break {page-break-after: always;}
}
CSS;

$this->registerCss($css);

for ($i = 0; $i < 3; ++$i) {
    foreach ($documents as $doc) {
        echo $doc['statement']
            . '<div class="page-break" style="page-break-after: always"></div>'
            . $doc['full_fine_report']
            . '<div class="page-break" style="page-break-after: always"></div>';
    }
}
