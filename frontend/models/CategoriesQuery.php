<?php

namespace frontend\models;

/**
 * This is the ActiveQuery class for [[CategoriesFormNew]].
 *
 * @see CategoriesFormNew
 */
class CategoriesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return CategoriesFormNew[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return CategoriesFormNew|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
