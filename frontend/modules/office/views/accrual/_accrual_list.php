<?php

DynaGrid::widget([
    'columns' => $columns,
    'storage' => DynaGrid::TYPE_COOKIE,
    'theme' => 'simple-striped',
    'gridOptions' => [
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax' => true,
        'panel' => [
            'heading' => '<h3 class="panel-title">' . Yii::t('app', 'Список задолженностей') . '</h3>',
            'before' => '{dynagrid}',
        ],
        'options' => ['id' => 'dynagrid-debts-options'],
        'toolbar' => [
            [
                'content' =>
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>',
                        ['/office/debt-details/create', 'id' => $model->id],
                        [
                            'class' => 'btn btn-success',
                            'title' => Yii::t('app', 'Добавить задолженность'),
//'href' => Url::to(['/office/debt-details/create', 'id' => $model->id]),
                        ]
                    ) .
                    Html::button('<i class="glyphicon glyphicon-plus"></i>',
                        [
                            'type' => 'button',
                            'title' => Yii::t('app', 'Добавить долг'),
                            'class' => 'btn btn-success',
                            'href' => Url::to(['/office/debt-details/create', 'id' => $model->id]),
                        ]
                    )/* . ' ' .
Html::a('<i class="glyphicon glyphicon-repeat"></i>',
['dynagrid-demo'],
[
'data-pjax' => 0,
'class' => 'btn btn-default',
'title' => Yii::t('app', 'Сбросить'),
]
)*/,
            ],
            /*[
            'content' => '{dynagridFilter}{dynagridSort}{dynagrid}'
            ],*/
            '{export}',
        ],
    ],
    'options' => ['id' => 'dynagrid-debts'] // a unique identifier is important
]);
