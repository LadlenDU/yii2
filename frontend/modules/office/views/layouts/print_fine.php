<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

$this->registerCssFile('/css/fine-style.css');
$this->registerCssFile('/css/fine-common.css');
$this->registerCssFile('/css/fine-bookkeeping.css');

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= Html::encode('Печать пени') ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php echo $content ?>
</body>
</html>
<?php $this->endPage() ?>

