<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "person_notice".
 *
 * @property int $id
 * @property string|null $key_name
 * @property string|null $notice
 *
 * @property UserPersonality[] $userPersonalities
 */
class PersonNotice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'person_notice';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['key_name', 'notice'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'key_name' => 'Key Name',
            'notice' => 'Notice',
        ];
    }

    /**
     * Gets query for [[UserPersonalities]].
     *
     * @return \yii\db\ActiveQuery|UserPersonalityQuery
     */
    public function getUserPersonalities()
    {
        return $this->hasMany(UserPersonality::class, ['idnotice' => 'id']);
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
