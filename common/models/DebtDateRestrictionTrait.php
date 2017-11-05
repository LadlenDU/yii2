<?php

namespace common\models;

trait DebtDateRestrictionTrait
{
    protected function addDateRestriction($column)
    {
        $time = new \DateTime('now');
        $topTime = $time->modify('-3 years')->modify('+1 month')->format('Y-m-d');
        $this->andWhere(['>=', $column, $topTime]);
    }
}
