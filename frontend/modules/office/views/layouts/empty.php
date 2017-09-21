<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= Html::encode($this->title) ?></title>
    <style>
        body {
            font-family: "Times New Roman", Georgia, serif;
            font-size: 16px;
        }
        table td {
            vertical-align: top;
            padding: 0.5em;
        }
    </style>
</head>
<body>
<?php echo $content ?>
</body>
</html>
<?php $this->endPage() ?>

