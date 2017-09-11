<?php

/**
 * @var kartik\tree\models\Tree     $node
 * @var kartik\form\ActiveForm      $form
 */

use bupy7\pages\models\Page;
#use yii\helpers\Html;

$pages = Page::find()->select(['id', 'title'])->all();

$listData = ['0' => Yii::t('app', 'Без содержания')];
foreach ($pages as $pg) {
    $listData[$pg->id] = $pg->title;
}

echo $form->field($node, 'page')->dropDownList($listData);

//echo '<select name="page">';
//
//foreach ($pages as $pg) {
//    echo "<option value='{$pg->id}'>" . Html::encode($pg->title) . "</option>";
//}
//
//echo '</select>';
