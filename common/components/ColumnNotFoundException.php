<?php

namespace common\components;

use yii\base\UserException;

class ColumnNotFoundException extends UserException
{
    protected $wrongColumnName;

    /**
     * @return mixed
     */
    public function getWrongColumnName()
    {
        return $this->wrongColumnName;
    }

    /**
     * @param mixed $wrongColumnName
     * @return ColumnNotFoundException
     */
    public function setWrongColumnName($wrongColumnName)
    {
        $this->wrongColumnName = $wrongColumnName;
        return $this;
    }
}
