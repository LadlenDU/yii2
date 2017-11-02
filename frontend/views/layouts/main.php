<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;

use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

    <style>
        body {
            background: url('/img/background-tile.jpg');
        }

        .form-container {
            display: none;
        }
    </style>

</head>
<body>

<!-- Yandex.Metrika counter --> <script type="text/javascript" > (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter46508586 = new Ya.Metrika({ id:46508586, clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks"); </script> <noscript><div><img src="https://mc.yandex.ru/watch/46508586" style="position:absolute; left:-9999px;" alt="" /></div></noscript> <!-- /Yandex.Metrika counter -->

<?php $this->beginBody() ?>

<div class="wrap">

    <div class="container">
        <?php Alert::widget(); ?>
        <div class="form-container"><?= $content ?></div>
    </div>
</div>

<?php

$this->registerJs(<<<JS
$(".form-container").css({opacity:0}).show().animate({opacity:1, 'margin-top':'5em'}, 1000);
JS
);

?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
