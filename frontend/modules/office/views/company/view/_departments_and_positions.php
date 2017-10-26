<?php

use yii\web\JsExpression;
use wbraganca\fancytree\FancytreeWidget;

$data1 = [
    ['title' => 'Администрация', 'key' => '2', 'expanded' => true, 'children' => [
        ['title' => 'Генеральный директор', 'key' => '3'],
        ['title' => 'Главный инженер', 'key' => '4'],
        ['title' => 'Исполнительный директор', 'key' => '5'],
        ['title' => 'Управляющий', 'key' => '6'],
        ['title' => 'Создать должность', 'data' => ['create_' => 'qaz']]
    ]]
];
$data2 = [
    ['title' => 'Правление', 'key' => '2', 'folder' => true, 'expanded' => true, 'checkbox' => true, 'children' => [
        ['title' => 'Председатель правления', 'checkbox' => true, 'key' => '3'],
        ['title' => 'Ревизор', 'checkbox' => true, 'key' => '4'],
        ['title' => 'Управляющий', 'checkbox' => true, 'key' => '5'],
        ['title' => 'Член правления', 'checkbox' => true, 'key' => '6'],
    ]]
];
$data3 = [
    ['title' => 'Бухгалтерия', 'key' => '2', 'folder' => true, 'expanded' => true, 'checkbox' => true, 'children' => [
        ['title' => 'Бухгалтер', 'checkbox' => true, 'key' => '3'],
        ['title' => 'Главный бухгалтер', 'checkbox' => true, 'key' => '4'],
        ['title' => 'Зам. главного бухгалтера', 'checkbox' => true, 'key' => '5'],
        ['title' => 'Экономист', 'checkbox' => true, 'key' => '6'],
    ]]
];
$data4 = [
    ['title' => 'Линейные сотрудники', 'key' => '2', 'folder' => true, 'expanded' => true, 'checkbox' => true, 'children' => [
        ['title' => 'Охранник', 'checkbox' => true, 'key' => '3'],
        ['title' => 'Разнорабочий', 'checkbox' => true, 'key' => '4'],
        ['title' => 'Сантехник', 'checkbox' => true, 'key' => '5'],
        ['title' => 'Электрик', 'checkbox' => true, 'key' => '6'],
    ]]
];
$data5 = [
    ['title' => 'ПТО', 'key' => '2', 'folder' => true, 'expanded' => true, 'checkbox' => true, 'children' => [
        ['title' => 'Ведущий инженер', 'checkbox' => true, 'key' => '3'],
        ['title' => 'Зав. складом', 'checkbox' => true, 'key' => '4'],
        ['title' => 'Инженер', 'checkbox' => true, 'key' => '5'],
        ['title' => 'Начальник ПТО', 'checkbox' => true, 'key' => '6'],
    ]]
];
$data6 = [
    ['title' => 'Аварийно-диспетчерская служба', 'key' => '2', 'folder' => true, 'expanded' => true, 'checkbox' => true, 'children' => [
        ['title' => 'Диспетчер', 'checkbox' => true, 'key' => '3'],
        ['title' => 'Консьерж', 'checkbox' => true, 'key' => '4'],
        ['title' => 'Начальник АДС', 'checkbox' => true, 'key' => '5'],
        ['title' => 'Оператор', 'checkbox' => true, 'key' => '6'],
    ]]
];

$w1 = FancytreeWidget::widget([
    'options' => [
        'source' => $data1,
        'checkbox' => true,
        'icon' => false,
        'renderNode' => new \yii\web\JsExpression('function($event, $data) {
                console.log($data);
                //if ($data.data.key == 6) {
                    //alert($data);
                //}
                //alert("EV: " + $event);
            }'
        ),
        /*'function($event, $data) {
        console.log($event);
        console.log($data);
        return;

        // Optionally tweak data.node.span
        var node = data.node;
        if(node.data.cstrender){
            var $span = $(node.span);
            $span.find("> span.fancytree-title").text(">> " + node.title).css({
                fontStyle: "italic"
              });
              $span.find("> span.fancytree-icon").css({
    //                      border: "1px solid green",
                backgroundImage: "url(skin-custom/customDoc2.gif)",
                backgroundPosition: "0 0"
              });
            }
    }',*/
    ]
]);

$w2 = FancytreeWidget::widget([
    'options' => [
        'source' => $data2,
        'checkbox' => true,
        'icon' => false,
    ]
]);

$w3 = FancytreeWidget::widget([
    'options' => [
        'source' => $data3,
        'checkbox' => true,
        'icon' => false,
    ]
]);

$w4 = FancytreeWidget::widget([
    'options' => [
        'source' => $data4,
        'checkbox' => true,
        'icon' => false,
    ]
]);

$w5 = FancytreeWidget::widget([
    'options' => [
        'source' => $data5,
        'checkbox' => true,
        'icon' => false,
    ]
]);

$w6 = FancytreeWidget::widget([
    'options' => [
        'source' => $data6,
        'checkbox' => true,
        'icon' => false,
    ]
]);


?>

<style>
    .department {
        /*float: left;*/
        /*display: inline-block;*/
        /*width: 250px;*/
        padding: 1em 2em;
    }
</style>

<?php

/*echo '<div class="department">' . $w1 . '</div>';
echo '<div class="department">' . $w1 . '</div>';
echo '<div class="department">' . $w1 . '</div>';
echo '<div class="department">' . $w1 . '</div>';
echo '<div class="department">' . $w1 . '</div>';*/

?>

<div class="row">
    <div class="clearfix  visible-lg visible-sm visible-md"></div>
    <div class="col-xs-12 col-sm-6 col-lg-4 department"><?= $w1 ?></div>
    <div class="col-xs-12 col-sm-6 col-lg-4 department"><?= $w2 ?></div>
    <div class="clearfix  visible-sm visible-md"></div>
    <div class="col-xs-12 col-sm-6 col-lg-4 department"><?= $w3 ?></div>
    <div class="clearfix  visible-lg"></div>
    <div class="col-xs-12 col-sm-6 col-lg-4 department"><?= $w4 ?></div>
    <div class="clearfix  visible-sm visible-md"></div>
    <div class="col-xs-12 col-sm-6 col-lg-4 department"><?= $w5 ?></div>
    <div class="col-xs-12 col-sm-6 col-lg-4 department"><?= $w6 ?></div>
</div>
