<?php

/**
 * @var yii\web\View $this
 * @var string $title
 * @var dektrium\user\Module $module
 */

echo "TT: $title\n";
echo $this->render('/message', [
    'title'  => $title,
    'module' => $this->module,
]);
