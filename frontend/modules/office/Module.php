<?php

namespace frontend\modules\office;

/**
 * office module definition class
 */
class Module extends \yii\base\Module
{
    public $layout = 'main';

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'frontend\modules\office\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
