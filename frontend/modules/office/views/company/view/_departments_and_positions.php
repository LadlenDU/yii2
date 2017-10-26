<?php

use yii\web\JsExpression;
use wbraganca\fancytree\FancytreeWidget;

$data1 = [
    ['title' => 'Администрация', 'key' => '2', 'expanded' => true, 'children' => [
        ['title' => 'Генеральный директор', 'key' => '3'],
        ['title' => 'Главный инженер', 'key' => '4'],
        ['title' => 'Исполнительный директор', 'key' => '5'],
        ['title' => 'Управляющий', 'key' => '6'],
        ['title' => 'Создать должность', 'data' => ['action' => 'create_position']],
    ]]
];
$data2 = [
    ['title' => 'Правление', 'key' => '2', 'folder' => true, 'expanded' => true, 'checkbox' => true, 'children' => [
        ['title' => 'Председатель правления', 'checkbox' => true, 'key' => '3'],
        ['title' => 'Ревизор', 'checkbox' => true, 'key' => '4'],
        ['title' => 'Управляющий', 'checkbox' => true, 'key' => '5'],
        ['title' => 'Член правления', 'checkbox' => true, 'key' => '6'],
        ['title' => 'Создать должность', 'data' => ['action' => 'create_position']],
    ]]
];
$data3 = [
    ['title' => 'Бухгалтерия', 'key' => '2', 'folder' => true, 'expanded' => true, 'checkbox' => true, 'children' => [
        ['title' => 'Бухгалтер', 'checkbox' => true, 'key' => '3'],
        ['title' => 'Главный бухгалтер', 'checkbox' => true, 'key' => '4'],
        ['title' => 'Зам. главного бухгалтера', 'checkbox' => true, 'key' => '5'],
        ['title' => 'Экономист', 'checkbox' => true, 'key' => '6'],
        ['title' => 'Создать должность', 'data' => ['action' => 'create_position']],
    ]]
];
$data4 = [
    ['title' => 'Линейные сотрудники', 'key' => '2', 'folder' => true, 'expanded' => true, 'checkbox' => true, 'children' => [
        ['title' => 'Охранник', 'checkbox' => true, 'key' => '3'],
        ['title' => 'Разнорабочий', 'checkbox' => true, 'key' => '4'],
        ['title' => 'Сантехник', 'checkbox' => true, 'key' => '5'],
        ['title' => 'Электрик', 'checkbox' => true, 'key' => '6'],
        ['title' => 'Создать должность', 'data' => ['action' => 'create_position']],
    ]]
];
$data5 = [
    ['title' => 'ПТО', 'key' => '2', 'folder' => true, 'expanded' => true, 'checkbox' => true, 'children' => [
        ['title' => 'Ведущий инженер', 'checkbox' => true, 'key' => '3'],
        ['title' => 'Зав. складом', 'checkbox' => true, 'key' => '4'],
        ['title' => 'Инженер', 'checkbox' => true, 'key' => '5'],
        ['title' => 'Начальник ПТО', 'checkbox' => true, 'key' => '6'],
        ['title' => 'Создать должность', 'data' => ['action' => 'create_position']],
    ]]
];
$data6 = [
    ['title' => 'Аварийно-диспетчерская служба', 'key' => '2', 'folder' => true, 'expanded' => true, 'checkbox' => true, 'children' => [
        ['title' => 'Диспетчер', 'checkbox' => true, 'key' => '3'],
        ['title' => 'Консьерж', 'checkbox' => true, 'key' => '4'],
        ['title' => 'Начальник АДС', 'checkbox' => true, 'key' => '5'],
        ['title' => 'Оператор', 'checkbox' => true, 'key' => '6'],
        ['title' => 'Создать должность', 'data' => ['action' => 'create_position']],
    ]]
];


$iconOkCancel = <<<HTML
<a href='javascript:void(0)' style='color:green'><i class='glyphicon glyphicon-ok'></i></a><a href='javascript:void(0)' style='color:red'><i class='glyphicon glyphicon-remove'></i></a>
HTML;

$renderNode = <<<JS
function(event, data) {
    var node = data.node;
    if (node.data && node.data.action == "create_position") {
        //console.log(data);
        var spanEl = $(node.span);
        spanEl.find("> span.fancytree-checkbox").remove();
        spanEl.find("> span.fancytree-title").unbind('click');
        spanEl.find("> span.fancytree-title").click(function(){
            //var edit = $("<input type='text' placeholder='Введите название должности'>$iconOkCancel");
            //edit.click(function(){alert(7);});
            //$(this).replaceWith(edit);
            node.editCreateNode("before"/*, {
                title: "",
                //folder: true
            }*/);
        });
    }
}
JS;


$w1 = FancytreeWidget::widget([
    'options' => [
        'source' => $data1,
        'checkbox' => true,
        'icon' => false,
        'renderNode' => new \yii\web\JsExpression($renderNode),
        'extensions' => ["edit"],
        'edit' => [
            // Available options with their default:
            'adjustWidthOfs' => 4,   // null: don't adjust input size to content
            'inputCss' => ['minWidth' => "3em"],
            'triggerStart' => ["f2", "dblclick", "shift+click", "mac+enter"],
            'beforeEdit' => new \yii\web\JsExpression('$.noop'),  // Return false to prevent edit mode
            'edit' => new \yii\web\JsExpression('$.noop'),        // Editor was opened (available as data.input)
            'beforeClose' => new \yii\web\JsExpression('$.noop'), // Return false to prevent cancel/save (data.input is available)
            'save' => new \yii\web\JsExpression('$.noop'),        // Save data.input.val() or return false to keep editor open
            'close' => new \yii\web\JsExpression('$.noop'),       // Editor was removed
        ],
    ],
]);

$w2 = FancytreeWidget::widget([
    'options' => [
        'source' => $data2,
        'checkbox' => true,
        'icon' => false,
        'renderNode' => new \yii\web\JsExpression($renderNode),
        'extensions' => ["edit"],
        'edit' => [
            // Available options with their default:
            'adjustWidthOfs' => 4,   // null: don't adjust input size to content
            'inputCss' => ['minWidth' => "3em"],
            'triggerStart' => ["f2", "dblclick", "shift+click", "mac+enter"],
            'beforeEdit' => new \yii\web\JsExpression('$.noop'),  // Return false to prevent edit mode
            'edit' => new \yii\web\JsExpression('$.noop'),        // Editor was opened (available as data.input)
            'beforeClose' => new \yii\web\JsExpression('$.noop'), // Return false to prevent cancel/save (data.input is available)
            'save' => new \yii\web\JsExpression('$.noop'),        // Save data.input.val() or return false to keep editor open
            'close' => new \yii\web\JsExpression('$.noop'),       // Editor was removed
        ],
    ]
]);

$w3 = FancytreeWidget::widget([
    'options' => [
        'source' => $data3,
        'checkbox' => true,
        'icon' => false,
        'renderNode' => new \yii\web\JsExpression($renderNode),
        'extensions' => ["edit"],
        'edit' => [
            // Available options with their default:
            'adjustWidthOfs' => 4,   // null: don't adjust input size to content
            'inputCss' => ['minWidth' => "3em"],
            'triggerStart' => ["f2", "dblclick", "shift+click", "mac+enter"],
            'beforeEdit' => new \yii\web\JsExpression('$.noop'),  // Return false to prevent edit mode
            'edit' => new \yii\web\JsExpression('$.noop'),        // Editor was opened (available as data.input)
            'beforeClose' => new \yii\web\JsExpression('$.noop'), // Return false to prevent cancel/save (data.input is available)
            'save' => new \yii\web\JsExpression('$.noop'),        // Save data.input.val() or return false to keep editor open
            'close' => new \yii\web\JsExpression('$.noop'),       // Editor was removed
        ],
    ]
]);

$w4 = FancytreeWidget::widget([
    'options' => [
        'source' => $data4,
        'checkbox' => true,
        'icon' => false,
        'renderNode' => new \yii\web\JsExpression($renderNode),
        'extensions' => ["edit"],
        'edit' => [
            // Available options with their default:
            'adjustWidthOfs' => 4,   // null: don't adjust input size to content
            'inputCss' => ['minWidth' => "3em"],
            'triggerStart' => ["f2", "dblclick", "shift+click", "mac+enter"],
            'beforeEdit' => new \yii\web\JsExpression('$.noop'),  // Return false to prevent edit mode
            'edit' => new \yii\web\JsExpression('$.noop'),        // Editor was opened (available as data.input)
            'beforeClose' => new \yii\web\JsExpression('$.noop'), // Return false to prevent cancel/save (data.input is available)
            'save' => new \yii\web\JsExpression('$.noop'),        // Save data.input.val() or return false to keep editor open
            'close' => new \yii\web\JsExpression('$.noop'),       // Editor was removed
        ],
    ]
]);

$w5 = FancytreeWidget::widget([
    'options' => [
        'source' => $data5,
        'checkbox' => true,
        'icon' => false,
        'renderNode' => new \yii\web\JsExpression($renderNode),
        'extensions' => ["edit"],
        'edit' => [
            // Available options with their default:
            'adjustWidthOfs' => 4,   // null: don't adjust input size to content
            'inputCss' => ['minWidth' => "3em"],
            'triggerStart' => ["f2", "dblclick", "shift+click", "mac+enter"],
            'beforeEdit' => new \yii\web\JsExpression('$.noop'),  // Return false to prevent edit mode
            'edit' => new \yii\web\JsExpression('$.noop'),        // Editor was opened (available as data.input)
            'beforeClose' => new \yii\web\JsExpression('$.noop'), // Return false to prevent cancel/save (data.input is available)
            'save' => new \yii\web\JsExpression('$.noop'),        // Save data.input.val() or return false to keep editor open
            'close' => new \yii\web\JsExpression('$.noop'),       // Editor was removed
        ],
    ]
]);

$w6 = FancytreeWidget::widget([
    'options' => [
        'source' => $data6,
        'checkbox' => true,
        'icon' => false,
        'renderNode' => new \yii\web\JsExpression($renderNode),
        'extensions' => ["edit"],
        'edit' => [
            // Available options with their default:
            'adjustWidthOfs' => 4,   // null: don't adjust input size to content
            'inputCss' => ['minWidth' => "3em"],
            'triggerStart' => ["f2", "dblclick", "shift+click", "mac+enter"],
            'beforeEdit' => new \yii\web\JsExpression('$.noop'),  // Return false to prevent edit mode
            'edit' => new \yii\web\JsExpression('$.noop'),        // Editor was opened (available as data.input)
            'beforeClose' => new \yii\web\JsExpression('$.noop'), // Return false to prevent cancel/save (data.input is available)
            'save' => new \yii\web\JsExpression('$.noop'),        // Save data.input.val() or return false to keep editor open
            'close' => new \yii\web\JsExpression('$.noop'),       // Editor was removed
        ],
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

    .fancytree-title input {
        color: black !important;
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
