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

        <div class="row middle-ad-block">
            <section class="col-md-6">разработка сайтов</section>
            <section class="col-md-6">реклама в интернете</section>
        </div>

        <section class="row">
            <div class="col-md-3 announcement">Анонс 1</div>
            <div class="col-md-3 announcement">Анонс 2</div>
            <div class="col-md-3 announcement">Анонс 3</div>
            <div class="col-md-3 announcement">Анонс 4</div>
        </section>

        <div class="row">
            <section class="col-md-7" style="background-color: #eee;">
                Обращение к посетителю:<br>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas vestibulum fringilla nulla non fringilla. Aenean eu urna sit amet eros euismod elementum. Aliquam tempor auctor lacus. Aliquam ornare ligula vel turpis aliquam ullamcorper. Phasellus massa dui, congue ut mi at, accumsan auctor arcu. Quisque at mauris sagittis nisl lobortis rhoncus id ut quam. Maecenas eget enim sed enim viverra laoreet. Phasellus interdum turpis urna, ac aliquam metus faucibus ut. Nulla finibus ut lectus eget venenatis. Aenean eget ullamcorper nibh, quis fringilla diam. Sed sed neque vel velit tincidunt suscipit bibendum sit amet tellus. Sed efficitur quam vel leo faucibus cursus.
            </section>
            <section class="col-md-5">
                Отзывы клиентов
            </section>
        </div>

        <section class="text-center site-map">
             Это мини карта сайта
        </section>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-7 text-left">
                &copy; sovetnik-gkh.ru <?= date('Y') ?>
            </div>
            <div class="col-md-5 text-right">
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
