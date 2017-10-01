<?php

namespace common\models;

use Yii;

class DebtDetailsExt extends DebtDetails
{
    /**
     * Возвращает тотальную сумму долга.
     */
    public static function getTotalOfColumn($fieldName)
    {
        $query = (new \yii\db\Query())->from(self::tableName());
        $sum = $query->sum($fieldName);
        return $sum;
    }
}
