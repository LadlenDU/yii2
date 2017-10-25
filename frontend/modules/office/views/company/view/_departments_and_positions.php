<?php

use yii\web\JsExpression;
use wbraganca\fancytree\FancytreeWidget;

$data1 = [
    ['title' => 'Администрация', 'key' => '2', 'expanded' => true, 'children' => [
        ['title' => 'Генеральный директор', 'key' => '3'],
        ['title' => 'Главный инженер', 'checkbox' => true, 'key' => '4'],
        ['title' => 'Исполнительный директор', 'checkbox' => true, 'key' => '5'],
        ['title' => 'Управляющий', 'checkbox' => true, 'key' => '6'],
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
        float: left;
        display: inline-block;
        width: 250px;
        margin: 1em 2em;
    }
</style>

<?php

/*echo '<div class="department">' . $w1 . '</div>';
echo '<div class="department">' . $w1 . '</div>';
echo '<div class="department">' . $w1 . '</div>';
echo '<div class="department">' . $w1 . '</div>';
echo '<div class="department">' . $w1 . '</div>';*/

?>

<div>
    <div class="department"><?= $w1 ?></div>
    <div class="department"><?= $w2 ?></div>
    <div class="department"><?= $w3 ?></div>
    <div class="department"><?= $w4 ?></div>
    <div class="department"><?= $w5 ?></div>
    <div class="department"><?= $w6 ?></div>
</div>
