<?php

namespace common\models;

use Yii;

class DebtDetailsExt extends DebtDetails
{
    /**
     * Возвращает тотальную сумму долга.
     */
    public static function getTotalAmount()
    {
        $query = (new \yii\db\Query())->from(self::tableName());
        $sum = $query->sum('amount');
        return $sum;
    }
}
