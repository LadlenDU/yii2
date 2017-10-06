<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Name]].
 *
 * @see Name
 */
class NameQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Name[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Name|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
