<?php

namespace frontend\models;

/**
 * This is the ActiveQuery class for [[ExecuterResponds]].
 *
 * @see ExecuterResponds
 */
class ExecuterRespondsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ExecuterResponds[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ExecuterResponds|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
