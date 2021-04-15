<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "favorite".
 *
 * @property int $iduser
 * @property int|null $favorite_task
 * @property int|null $favorite_user
 * @property int $id
 *
 * @property Tasks $favoriteTask
 * @property Users $favoriteUser
 * @property Users $iduser0
 */
class Favorite extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'favorite';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['iduser'], 'required'],
            [['iduser', 'favorite_task', 'favorite_user'], 'integer'],
            [['iduser'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['iduser' => 'id']],
            [['favorite_task'], 'exist', 'skipOnError' => true, 'targetClass' => Tasks::class, 'targetAttribute' => ['favorite_task' => 'id']],
            [['favorite_user'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['favorite_user' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'iduser' => 'Iduser',
            'favorite_task' => 'Favorite Task',
            'favorite_user' => 'Favorite User',
            'id' => 'ID',
        ];
    }

    /**
     * Gets query for [[FavoriteTask]].
     *
     * @return \yii\db\ActiveQuery|TasksQuery
     */
    public function getFavoriteTask()
    {
        return $this->hasOne(Tasks::class, ['id' => 'favorite_task']);
    }

    /**
     * Gets query for [[FavoriteUser]].
     *
     * @return \yii\db\ActiveQuery|UsersQuery
     */
    public function getFavoriteUser()
    {
        return $this->hasOne(Users::class, ['id' => 'favorite_user']);
    }

    /**
     * Gets query for [[Iduser0]].
     *
     * @return \yii\db\ActiveQuery|UsersQuery
     */
    public function getIduser0()
    {
        return $this->hasOne(Users::class, ['id' => 'iduser']);
    }

    /**
     * {@inheritdoc}
     * @return FavoriteQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FavoriteQuery(get_called_class());
    }
}
