<?php

/* @var $this yii\web\View */

use kartik\tree\TreeView;
use kartik\tree\Module;
use common\models\Tree;

$this->title = 'My Yii Application';

/*echo TreeView::widget([
    // single query fetch to render the tree
    'query'             => Tree::find()->addOrderBy('root, lft'),
    'headingOptions'    => ['label' => 'Categories'],
    'isAdmin'           => false,                       // optional (toggle to enable admin mode)
    'displayValue'      => 1,                           // initial display value
    //'softDelete'      => true,                        // normally not needed to change
    //'cacheSettings'   => ['enableCache' => true]      // normally not needed to change
]);*/

echo TreeView::widget([
    //'query' => \app\models\Product::find()->addOrderBy('root, lft'),
    'query'             => Tree::find()->addOrderBy('root, lft'),
    'headingOptions' => ['label' => Yii::t('app', 'Категории')],
    //'rootOptions' => ['label'=>'<span class="text-primary">Root</span>'],
    'fontAwesome' => true,
    'isAdmin' => true,
    'displayValue' => 1,
    /*'iconEditSettings'=> [
        'show' => 'list',
        'listData' => [
            'folder' => 'Folder',
            'file' => 'File',
            'mobile' => 'Phone',
            'bell' => 'Bell',
        ]
    ],*/
    //'softDelete' => true,
    //'cacheSettings' => ['enableCache' => true],
    'nodeAddlViews' => [
        Module::VIEW_PART_2 => '@backend/views/site/_treePart2'
    ],
]);

