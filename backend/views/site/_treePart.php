<?php

/**
 * @var kartik\tree\models\Tree     $node
 * @var kartik\form\ActiveForm      $form
 */

use bupy7\pages\models\Page;

$pages = Page::find()->select(['id', 'title'])->all();

$listData = ['0' => Yii::t('app', 'Без содержания')];
foreach ($pages as $pg) {
    $listData[$pg->id] = $pg->title;
}

echo $form->field($node, 'pages')->dropDownList($listData);
