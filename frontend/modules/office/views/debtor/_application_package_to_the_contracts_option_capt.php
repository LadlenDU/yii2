<?php
/**
 * @var yii\web\View $this
 * @var common\models\ApplicationPackageToTheContract $apc
 */

$apcStr = '';
if ($apc->created_at) {
    date_default_timezone_set('GMT');
    $createdAtTs = strtotime($apc->created_at);
    //TODO: убрать хардкод 'Europe/Moscow'
    date_default_timezone_set('Europe/Moscow');
    $createdAt = date('d.m.Y - H:i', $createdAtTs);
    $apcStr = Yii::t('app', 'Приложение № {number} от {created_at}', ['number' => $apc->number, 'created_at' => $createdAt]);
} else {
    $apcStr = Yii::t('app', 'Приложение № {number}', ['number' => $apc->number]);
}

echo $apcStr;
