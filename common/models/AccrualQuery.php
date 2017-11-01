<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Accrual]].
 *
 * @see Accrual
 */
class AccrualQuery extends \yii\db\ActiveQuery
{
    use \common\models\DebtDateRestrictionTrait;

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
        $this->addDateRestriction('accrual_date');
        return parent::all($db);
    }

    public function count($q = '*', $db = null)
    {
        $this->addDateRestriction('accrual_date');
        return parent::count($q, $db);
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
