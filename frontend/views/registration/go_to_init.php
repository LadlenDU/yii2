<?php

/**
 * @var yii\web\View $this
 * @var string $title
 * @var bool $need_registration_form
 * @var dektrium\user\Module $module
 */

use yii\helpers\Html;
use common\models\RegistrationType;

$this->title = $title;

$regType = new RegistrationType;

echo $this->render('/message', [
    'title' => $title,
    'module' => $module,
]);

if ($need_registration_form) {
    echo Html::a(yii::t('app', 'Нажмите для продолжения регистрации'), '/registration/init');
}
