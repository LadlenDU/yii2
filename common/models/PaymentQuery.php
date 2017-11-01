<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Payment]].
 *
 * @see Payment
 */
class PaymentQuery extends \yii\db\ActiveQuery
{
    use \common\models\DebtDateRestrictionTrait;

    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Payment[]|array
     */
    public function all($db = null)
    {
        $this->addDateRestriction('payment_date');
        return parent::all($db);
    }

    public function count($q = '*', $db = null)
    {
        $this->addDateRestriction('payment_date');
        return parent::count($q, $db);
    }

    /**
     * @inheritdoc
     * @return Payment|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
