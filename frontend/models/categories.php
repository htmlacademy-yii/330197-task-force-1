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
class Categories extends \yii\db\ActiveRecord
{
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
            [['category', 'icon'], 'string', 'max' => 255],
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
     * @return ExecutersCategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ExecutersCategoryQuery(get_called_class());
    }
    
}
