<?php

namespace frontend\models;

/**
 * This is the ActiveQuery class for [[FeedbackAboutExecuter]].
 *
 * @see FeedbackAboutExecuter
 */
class FeedbackAboutExecuterQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return FeedbackAboutExecuter[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return FeedbackAboutExecuter|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
