<?php

namespace frontend\models;

/**
 * This is the ActiveQuery class for [[CommentsForTask]].
 *
 * @see CommentsForTask
 */
class CommentsForTaskQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return CommentsForTask[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return CommentsForTask|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
