<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;

#use yii\bootstrap\Nav;
#use yii\bootstrap\NavBar;
#use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use common\models\Tree;

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

    <header class="container">
        <div class="row header">
            <div class="col-md-4 text-center"><?= Html::img('/img/logo.jpg', ['alt' => Yii::t('app', 'Логотип'), 'width' => 138, 'height' => 112]) ?></div>
            <div class="col-md-3 text-center">Заказ онлайн</div>
            <div class="col-md-5 text-center">
                Тел: +7 (123) 123 12 34<br>
                г. Москва, пр. Гоголя 25A
            </div>
        </div>
        <div class="row">
            <section class="col-md-3 text-center">Сфера деятельности</section>
            <nav class="col-md-7 text-center">
                <?php
                $menuElems = Tree::getElementsByLevel();
                foreach ($menuElems as $mElem) {
                    echo Html::a($mElem['name'], ['/pages/default/index', 'page' => $mElem['alias']]) . ' / ';
                }
                ?>
            </nav>
            <div class="col-md-2 text-right">
                <?php
                $menuItems = [];
                if (Yii::$app->user->isGuest) {
                    $menuItems[] = ['label' => Yii::t('app', 'Войти'), 'url' => ['/user/security/login']];
                    $menuItems[] = ['label' => Yii::t('app', 'Зарегистрироваться'), 'url' => ['/user/registration/register']];
                    //['label' => 'Sign in', 'url' => ['/user/security/login']]
                    /*echo Html::a(Yii::t('app', 'Войти'),
                            '/user/security/login'
                        ) . "\n";
                    echo Html::a(Yii::t('app', 'Зарегистрироваться'),
                        '/user/registration/register'
                    );*/
                } else {
                    $menuItems[] = ['label' => Yii::t('app', 'Личный кабинет'), 'url' => ['/office']];
                    $menuItems[] = [
                        'label' => Yii::t('app', 'Выйти ({username})',
                            ['username' => Yii::$app->user->identity->username]),
                        'url' => ['/user/security/logout'],
                        'linkOptions' => ['data-method' => 'post']
                    ];
                    ?>
                    <!--<form method="post" action="<?/*= Url::to('/user/security/logout') */ ?>">
                        <?/*= Html::submitButton(Yii::t('app', 'Выйти ({username})',
                            ['username' => Yii::$app->user->identity->username]))
                        */ ?>
                    </form>-->
                    <?php
                    /*echo Html::a(Yii::t('app', 'Выйти ({username})',
                        ['username' => Yii::$app->user->identity->username]),
                        '/user/security/logout'
                    );*/
                    /*['label' => 'Sign out (' . Yii::$app->user->identity->username . ')',
                        'url' => ['/user/security/logout'],
                        'linkOptions' => ['data-method' => 'post']],
                    ['label' => 'Register', 'url' => ['/user/registration/register'], 'visible' => Yii::$app->user->isGuest]*/
                }

                echo Nav::widget([
                    'options' => ['class' => 'navbar-nav navbar-right'],
                    'items' => $menuItems,
                ]);
                ?>
            </div>
        </div>
    </header>

    <div class="container">
        <?php /*Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) */
        Alert::widget();
        echo $content;
        ?>

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
