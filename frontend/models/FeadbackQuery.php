<?php

namespace frontend\models;

/**
 * This is the ActiveQuery class for [[Feadback]].
 *
 * @see Feadback
 */
class FeadbackQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Feadback[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Feadback|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
