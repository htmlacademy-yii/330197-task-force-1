<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "feedback_about_executer".
 *
 * @property int $target_task_id
 * @property int|null $target_user_id
 * @property int|null $id_user
 * @property int|null $rate
 * @property string|null $dt_add
 * @property string|null $description
 * @property int $id
 *
 * @property Tasks $targetTask
 * @property Users $targetUser
 * @property Users $user
 */
class FeedbackAboutExecuter extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'feedback_about_executer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['target_task_id'], 'required'],
            [['target_task_id', 'target_user_id', 'id_user', 'rate'], 'integer'],
            [['dt_add'], 'safe'],
            [['description'], 'string'],
            [['target_task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tasks::className(), 'targetAttribute' => ['target_task_id' => 'id']],
            [['target_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['target_user_id' => 'id']],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['id_user' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'target_task_id' => 'Target Task ID',
            'target_user_id' => 'Target User ID',
            'id_user' => 'Id User',
            'rate' => 'Rate',
            'dt_add' => 'Dt Add',
            'description' => 'Description',
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
     * Gets query for [[TargetUser]].
     *
     * @return \yii\db\ActiveQuery|UsersQuery
     */
    public function getTargetUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'target_user_id']);
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
     * @return FeedbackAboutExecuterQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FeedbackAboutExecuterQuery(get_called_class());
    }
}
