<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Debtor]].
 *
 * @see Debtor
 */
class DebtorQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    public function prepare($builder)
    {
        $this->andWhere(['debtor.user_id' => \Yii::$app->user->identity->getId()]);
        return parent::prepare($builder);
    }

    /**
     * @inheritdoc
     * @return Debtor[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Debtor|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
