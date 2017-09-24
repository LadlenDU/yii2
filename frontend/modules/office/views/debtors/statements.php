<?php
/**
 * @var yii\web\View $this
 * @var array $params
 */

use yii\helpers\Html;

$css = <<<CSS
@media print {
    .page-break {page-break-after: always;}
}
CSS;

$this->registerCss($css);

?>

<?php echo $this->render('statement', $params) ?>

<div class="page-break"></div>
