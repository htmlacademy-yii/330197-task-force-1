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
class UsersForm extends \yii\db\ActiveRecord
{
    public $free = 'Сейчас свободен';
    public $online = 'Сейчас онлайн';
    public $feedback = 'Есть отзывы';
    public $favorite = 'В избранном';
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
            [['icon', 'free', 'online', 'feedback', 'favorite', 'search'], 'string', 'max' => 255],
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
            'online' => $this->online,
            'free' => $this->free,
            'feedback' => $this->feedback,
            'favorite' => $this->favorite,
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
