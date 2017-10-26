<?php

use yii\grid\GridView;
use yii\data\ArrayDataProvider;
use kartik\detail\DetailView;
//use yii\helpers\ArrayHelper;

$elements = [
    [
        'ФИО' => 'Дорофеев Дмитрий Александрович',
        'Должность' => 'Зав. складом',
        'Моб. телефон' => '+7 (968) 987-11-12',
        'Email' => 'dummy@dummy.com',
        'Действия' => [
            'attribute' => 'price',
            //'label' => ,
            'format' => 'html',
            'value' => function ($data) {
                return '<a href="/court/view?id=1" title="Просмотр" aria-label="Просмотр" data-pjax="0"><span class="glyphicon glyphicon-eye-open"></span></a> <a href="/court/update?id=1" title="Редактировать" aria-label="Редактировать" data-pjax="0"><span class="glyphicon glyphicon-pencil"></span></a> <a href="/court/delete?id=1" title="Удалить" aria-label="Удалить" data-pjax="0" data-confirm="Вы уверены, что хотите удалить этот элемент?" data-method="post"><span class="glyphicon glyphicon-trash"></span></a>';
            },
        ],
    ]
];

$dataProvider = new ArrayDataProvider([
    'allModels' => $elements,
    /*'sort' => [
        'attributes' => ['date'],
    ],*/
    /*'pagination' => [
        'pageSize' => 100,
    ],*/
]);

$this->registerJS(<<<JS
$("#add_collaborator").click(function(e) {
    e.preventDefault();
    $("#cont_coll").fadeOut(300, function() {
        $("#add_coll_form").fadeIn(300);      
    });
    
    return false;
});
JS
);

$attributes = [
    [
        'group' => true,
        'label' => Yii::t('app', 'Данные о сотруднике'),
        'rowOptions' => ['class' => 'info'],
    ],
    [
        'attribute' => 'phone',
        'label' => 'Фамилия',
        'value' => '',
    ],
    [
        'attribute' => 'LS_EIRC',
        'label' => 'Имя',
        'value' => '',
    ],
    [
        'attribute' => 'LS_IKU_provider',
        'label' => 'Отчество',
        'value' => '',
    ],
    [
        'attribute' => 'IKU',
        'label' => 'Email',
        'value' => '',
    ],
    [
        'attribute' => 'IKU',
        'label' => 'Телефон',
        'value' => '',
    ],
    [
        'group' => true,
        'label' => Yii::t('app', 'Отдел и должность'),
        'rowOptions' => ['class' => 'info'],
    ],
    [
        'attribute' => 'name_id',
        'label' => 'Отдел',
        'format' => 'raw',
        'type' => DetailView::INPUT_SELECT2,
        'widgetOptions' => [
            'data' => ['Администрация', 'Правление', 'Бухгалтерия', 'Линейные сотрудники', 'ПТО', 'Аварийно-диспетчерская служба'],
            'options' => ['placeholder' => Yii::t('app', 'Выберите отдел ...')],
            'pluginOptions' => ['allowClear' => true, 'width' => '100%'],
        ],
    ],
    [
        'attribute' => 'location_id',
        'label' => 'Должность',
        'format' => 'raw',
        'type' => DetailView::INPUT_SELECT2,
        'widgetOptions' => [
            'data' => ['Генеральный директор', 'Главный инженер', 'Исполнительный директор', 'Управляющий', 'Создать должность'],
            'options' => ['placeholder' => Yii::t('app', 'Выберите должность ...')],
            'pluginOptions' => ['allowClear' => true, 'width' => '100%'],
        ],
    ],
];

?>

<p><a class="btn btn-success" id="add_collaborator" href="#">Добавить сотрудника</a></p>

<div id="cont_coll">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
    ]); ?>
</div>

<div id="add_coll_form" style="display: none">
    <!--<div class="row">
        <div class="col-xs-12 col-sm-6">

        </div>
        <div class="col-xs-12 col-sm-6">
        </div>
    </div>-->
    <?= DetailView::widget([
        'model' => new \common\models\Debtor(),
        'attributes' => $attributes,
        //'mode' => DetailView::MODE_VIEW,
        'mode' => DetailView::MODE_EDIT,
        'bordered' => true,
        'striped' => false,
        'condensed' => false,
        'responsive' => true,
        'hover' => true,
        'hAlign' => 'left',
        'vAlign' => 'middle',
        'panel' => [
            'heading' => 'Данные сотрудника',
            'type' => DetailView::TYPE_INFO,
        ],
        //'buttons1' => '{update}',
        'container' => ['id' => 'collaborator-data'],
    ]); ?>
</div>
