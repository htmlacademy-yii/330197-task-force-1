<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "categories".
 *
 * @property int $id
 * @property string|null $category
 * @property string|null $icon
 *
 * @property ExecutersCategory[] $executersCategories
 * @property Tasks[] $tasks
 */
class CategoriesFormNew extends \yii\db\ActiveRecord
{
    public $no_executers = 'Без откликов';
    public $no_address = 'Удалённая работа';
    public $period = 'Период';
    public $search;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category'],'safe'],
            [['icon', 'no_executers', 'no_address', 'period', 'search'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category' => 'Category',
            'icon' => 'Icon',
            'no_address' => $this->no_address,
            'no_executers' => $this->no_executers,
            'period' => $this->period,
            'search' => $this->search,
        ];
    }

    /**
     * Gets query for [[ExecutersCategories]].
     *
     * @return \yii\db\ActiveQuery|ExecutersCategoryQuery
     */
    public function getExecutersCategories()
    {
        return $this->hasMany(ExecutersCategory::class, ['idcategory' => 'id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery|ExecutersCategoryQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Tasks::class, ['idcategory' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return CategoriesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CategoriesQuery(get_called_class());
    }
}
