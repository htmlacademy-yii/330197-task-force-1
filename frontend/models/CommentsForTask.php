<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "comments_for_task".
 *
 * @property int $target_task_id
 * @property string|null $dt_add
 * @property string|null $notetext
 * @property int $id_user
 * @property int $id
 *
 * @property Tasks $targetTask
 * @property Users $user
 */
class CommentsForTask extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comments_for_task';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['target_task_id', 'id_user'], 'required'],
            [['target_task_id', 'id_user'], 'integer'],
            [['dt_add'], 'safe'],
            [['notetext'], 'string'],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['id_user' => 'id']],
            [['target_task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tasks::className(), 'targetAttribute' => ['target_task_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'target_task_id' => 'Target Task ID',
            'dt_add' => 'Dt Add',
            'notetext' => 'Notetext',
            'id_user' => 'Id User',
            'id' => 'ID',
        ];
    }

    /**
     * Gets query for [[TargetTask]].
     *
     * @return \yii\db\ActiveQuery|TasksQuery
     */
    public function getTargetTask()
    {
        return $this->hasOne(Tasks::className(), ['id' => 'target_task_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery|UsersQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'id_user']);
    }

    /**
     * {@inheritdoc}
     * @return CommentsForTaskQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CommentsForTaskQuery(get_called_class());
    }
}
