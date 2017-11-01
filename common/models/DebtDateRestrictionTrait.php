<?php

namespace common\models;

trait DebtDateRestrictionTrait
{
    protected function addDateRestriction($column)
    {
        $time = new \DateTime('now');
        $topTime = $time->modify('-3 years')->format('Y-m-d');
        $this->where(['>=', $column, $topTime]);
    }
}
