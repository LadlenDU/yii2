<?php

namespace common\models;

use Yii;
use yii\base\Model;

class Debtor extends Model
{
    public function putDebtorsFromArray(array $list)
    {
        $headers = [];

        $firstRow = true;
        foreach ($list as $elem) {
            if ($firstRow) {
                $elem
                $firstRow = false;
                continue;
            }
        }
    }
}
