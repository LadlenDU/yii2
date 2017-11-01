<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[DebtorCohabitant]].
 *
 * @see DebtorCohabitant
 */
class DebtorCohabitantQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return DebtorCohabitant[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return DebtorCohabitant|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
