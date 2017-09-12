<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
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
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    /*NavBar::begin([
        'brandLabel' => 'My Company',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => 'Home', 'url' => ['/site/index']],
        ['label' => 'About', 'url' => ['/site/about']],
        ['label' => 'Contact', 'url' => ['/site/contact']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();*/
    ?>

    <header>
        <div class="row">
            <div class="col-md-4 text-center"><?= Html::img('/img/logo.jpg', ['alt' => Yii::t('app', 'Логотип'), 'width' => 238, 'height' => 212]) ?></div>
            <div class="col-md-3 text-center">Заказ онлайн</div>
            <div class="col-md-5 text-center">
                Тел: +7 (123) 123 12 34<br>
                г. Москва, пр. Гоголя 25A
            </div>
        </div>
        <div class="row">
            <section class="col-md-4 text-center">Сфера деятельности</section>
            <nav class="col-md-8 text-center">
                <?= Html::a(Yii::t('app', 'Студия')) ?> /
                <?= Html::a(Yii::t('app', 'Услуги')) ?> /
                <?= Html::a(Yii::t('app', 'Портфолио')) ?> /
                <?= Html::a(Yii::t('app', 'Клиенты')) ?> /
                <?= Html::a(Yii::t('app', 'Контакты')) ?>
            </nav>
        </div>
    </header>

    <div class="container">
        <? /*= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) */ ?>
        <?= Alert::widget() ?>
        <? /*= $content */ ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <p class="pull-left">&copy; sovetnik-gkh.ru <?= date('Y') ?></p>
            </div>
            <div class="col-md-5">
                <?=
                Html::a(
                    Html::img('/img/social/VK.png', ['alt' => Yii::t('app', 'Вконтакте'), 'width' => 30, 'height' => 30]),
                    'http://vk.com',
                    ['target' => '_blank']
                )
                ?>
                <?=
                Html::a(
                    Html::img('/img/social/facebook.png', ['alt' => Yii::t('app', 'Facebook'), 'width' => 30, 'height' => 30]),
                    'http://facebook.com',
                    ['target' => '_blank']
                )
                ?>
                <?=
                Html::a(
                    Html::img('/img/social/twitter.png', ['alt' => Yii::t('app', 'Twitter'), 'width' => 30, 'height' => 30]),
                    'http://twitter.com',
                    ['target' => '_blank']
                )
                ?>
                <?=
                Html::a(
                    Html::img('/img/social/IN.png', ['alt' => Yii::t('app', 'IN'), 'width' => 30, 'height' => 30]),
                    'http://in.com',
                    ['target' => '_blank']
                )
                ?>
            </div>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
