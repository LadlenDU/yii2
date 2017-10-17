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
    <title><?= Html::encode('Печать пени') ?></title>
    <style>
        tbody {
            display: table-row-group;
            vertical-align: middle;
            border-color: inherit;
        }

        h4 {
            display: block;
            -webkit-margin-before: 1.33em;
            -webkit-margin-after: 1.33em;
            -webkit-margin-start: 0;
            -webkit-margin-end: 0;
            font-weight: bold;
        }

        html, body, div, span, applet, object, iframe, h1, h2, h3, h4, h5, h6, p, blockquote, pre, a, abbr, acronym, address, big, cite, code, del, dfn, em, font, img, ins, kbd, q, s, samp, small, strike, strong, sub, sup, tt, var, b, u, i, center, dl, dt, dd, ol, ul, li, fieldset, form, label, legend, table, caption, tbody, tfoot, thead, tr, th, td, input[type=text], textarea {
            margin: 0;
            padding: 0;
            border: 0;
            outline: none 0;
            background: transparent;
        }

        body {
            font-family: "Arial", Georgia, sans-serif;
            font-size: 14px;
            line-height: 150%;
            color: black;
        }

        table {
            border-collapse: collapse;
            border-spacing: 0;
        }

        .judge-table {
            width: 100%;
            margin: 12px 0;
        }

        /* ==== */
        .judge-table td {
            border: 1px solid #ccc;
            padding: 8px 6px;
        }

        .judge-table td {
            white-space: nowrap;
            font-size: 12px;
            text-align: center;
        }

        .jt-2 td {
            padding: 4px 6px;
            vertical-align: middle;
        }

        .jt-2 td, .jt-4 td {
            text-align: right;
        }

        .center_column h2, .center_column h3, .center_column h4 {
            padding: 8px 10px 9px 12px;
            margin-top: 12px;
            color: #32529e;
            background: #f1f1f3;
            font-size: 16px;
            text-transform: none;
            font-weight: normal;
        }

        .content-text h2, .content-text h3, .content-text h4 {
            padding: 0;
            color: #990000;
            background: none;
            margin-top: 24px;
        }

    </style>
    <?php $this->head() ?>
</head>
<body>
<?php echo $content ?>
</body>
</html>
<?php $this->endPage() ?>

