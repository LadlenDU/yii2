<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Court]].
 *
 * @see Court
 */
class CourtQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    public function prepare($builder)
    {
        $this->andWhere(['user_id' => \Yii::$app->user->identity->getId()]);
        return parent::prepare($builder);
    }

    /**
     * @inheritdoc
     * @return Court[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Court|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
