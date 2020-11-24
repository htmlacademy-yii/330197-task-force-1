<?php

namespace frontend\models;

/**
 * This is the ActiveQuery class for [[Tasks_2]].
 *
 * @see Tasks_2
 */
class TasksQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Tasks_2[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Tasks_2|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
