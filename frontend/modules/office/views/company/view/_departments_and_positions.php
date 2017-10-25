<?php

use yii\web\JsExpression;
use wbraganca\fancytree\FancytreeWidget;

$data1 = [
    ['title' => 'Администрация', 'key' => '2', 'folder' => true, 'expanded' => true, 'children' => [
        ['title' => 'Генеральный директор', 'key' => '3'],
        ['title' => 'Главный инженер', 'key' => '4'],
        ['title' => 'Исполнительный директор', 'key' => '5'],
        ['title' => 'Управляющий', 'key' => '6'],
    ]]
];
$data2 = [
    ['title' => 'Правление', 'key' => '2', 'folder' => true, 'expanded' => true, 'children' => [
        ['title' => 'Председатель правления', 'key' => '3'],
        ['title' => 'Ревизор', 'key' => '4'],
        ['title' => 'Управляющий', 'key' => '5'],
        ['title' => 'Член правления', 'key' => '6'],
    ]]
];
$data3 = [
    ['title' => 'Бухгалтерия', 'key' => '2', 'folder' => true, 'expanded' => true, 'children' => [
        ['title' => 'Бухгалтер', 'key' => '3'],
        ['title' => 'Главный бухгалтер', 'key' => '4'],
        ['title' => 'Зам. главного бухгалтера', 'key' => '5'],
        ['title' => 'Экономист', 'key' => '6'],
    ]]
];
$data4 = [
    ['title' => 'Линейные сотрудники', 'key' => '2', 'folder' => true, 'expanded' => true, 'children' => [
        ['title' => 'Охранник', 'key' => '3'],
        ['title' => 'Разнорабочий', 'key' => '4'],
        ['title' => 'Сантехник', 'key' => '5'],
        ['title' => 'Электрик', 'key' => '6'],
    ]]
];
$data5 = [
    ['title' => 'ПТО', 'key' => '2', 'folder' => true, 'expanded' => true, 'children' => [
        ['title' => 'Ведущий инженер', 'key' => '3'],
        ['title' => 'Зав. складом', 'key' => '4'],
        ['title' => 'Инженер', 'key' => '5'],
        ['title' => 'Начальник ПТО', 'key' => '6'],
    ]]
];
$data6 = [
    ['title' => 'Аварийно-диспетчерская служба', 'key' => '2', 'folder' => true, 'expanded' => true, 'children' => [
        ['title' => 'Диспетчер', 'key' => '3'],
        ['title' => 'Консьерж', 'key' => '4'],
        ['title' => 'Начальник АДС', 'key' => '5'],
        ['title' => 'Оператор', 'key' => '6'],
    ]]
];

$w1 = FancytreeWidget::widget([
    'options' => [
        'source' => $data1,
        /*'extensions' => ['dnd'],
        'dnd' => [
            'preventVoidMoves' => true,
            'preventRecursiveMoves' => true,
            'autoExpandMS' => 400,
            'dragStart' => new JsExpression('function(node, data) {
				return true;
			}'),
            'dragEnter' => new JsExpression('function(node, data) {
				return true;
			}'),
            'dragDrop' => new JsExpression('function(node, data) {
				data.otherNode.moveTo(node, data.hitMode);
			}'),
        ],*/
    ]
]);

$w2 = FancytreeWidget::widget([
    'options' => [
        'source' => $data2,
    ]
]);

$w3 = FancytreeWidget::widget([
    'options' => [
        'source' => $data3,
    ]
]);

$w4 = FancytreeWidget::widget([
    'options' => [
        'source' => $data4,
    ]
]);

$w5 = FancytreeWidget::widget([
    'options' => [
        'source' => $data5,
    ]
]);

$w6 = FancytreeWidget::widget([
    'options' => [
        'source' => $data6,
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
