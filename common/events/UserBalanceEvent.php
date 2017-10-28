<?php

namespace common\events;

use yii\base\Event;

class UserBalanceEvent extends Event
{
    //public $operationName;
    public $amountToChange;
    public $oldBalance;
}
