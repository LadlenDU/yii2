<?php

namespace common\models;

//use Yii;

class Tree extends \kartik\tree\models\Tree
{
    public $page = null;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tree';
    }
}
