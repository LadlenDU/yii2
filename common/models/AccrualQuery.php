<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Accrual]].
 *
 * @see Accrual
 */
class AccrualQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Accrual[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Accrual|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
