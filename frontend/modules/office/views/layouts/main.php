<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */


if (Yii::$app->controller->action->id === 'login') {
    /**
     * Do not use this code in your template. Remove it.
     * Instead, use the code  $this->layout = '//main-login'; in your controller.
     */
    echo $this->render(
        'main-login',
        ['content' => $content]
    );
} else {

    if (class_exists('backend\assets\AppAsset')) {
        backend\assets\AppAsset::register($this);
    } else {
        app\assets\AppAsset::register($this);
    }

    dmstr\web\AdminLteAsset::register($this);

    $directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
    ?>
    <?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <style>
            .hu-pane .tabs-krajee .nav-tabs .glyphicon {
                margin-right: .5em;
            }

            .tbl-debtor-fin-info [class^="col-"] {
                padding-top: .5em;
                padding-bottom: .5em;
            }

            .tbl-debtor-fin-info {
                margin-bottom: 2em;
            }

            #fin_data_container {
                margin-top: 2em;
                /*text-align: center;*/
            }

            .menu-balance {
                float: left;
                padding: 18px 15px 0;
            }

            /*TODO: попытка уменьшения размера*/
            body {
                font-size: 1.1em !important;
            }

            h1 {
                font-size: 1.5em !important;
            }

            .content-header > h1 {
                font-size: 1.2em !important;
            }

            .main-header .logo {
                font-size: 1.5em !important;
            }

            .sidebar-mini.sidebar-collapse .main-header .logo > .logo-mini {
                font-size: 1.1em !important;
            }

            .sidebar-menu li.header {
                font-size: 0.8em !important;
            }

            .form-control {
                height: 3em !important;
                font-size: 1em !important;
            }

            .panel-title {
                font-size: 1.5em;
            }

            #dynagrid-debtors-grid-modal {
                z-index: 1051;
            }

            .jkh-standart-form {
                width: 90%;
                margin: 0 auto;
            }

            .jkh-standart-form .required label:after {
                content: "*";
                color: red;
                margin-left: .3em;
            }
        </style>

    </head>
    <body class="hold-transition skin-blue sidebar-mini">
    <?php $this->beginBody() ?>
    <div class="wrapper">

        <?= $this->render(
            'header.php',
            ['directoryAsset' => $directoryAsset]
        ) ?>

        <?= $this->render(
            'left.php',
            ['directoryAsset' => $directoryAsset]
        )
        ?>

        <?= $this->render(
            'content.php',
            ['content' => $content, 'directoryAsset' => $directoryAsset]
        ) ?>

    </div>

    <?php $this->endBody() ?>
    </body>
    </html>
    <?php $this->endPage() ?>
<?php } ?>
