<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "executer_responds".
 *
 * @property int $target_task_id
 * @property int|null $id_user
 * @property string|null $dt_add
 * @property string|null $notetext
 * @property int $id
 *
 * @property Tasks $targetTask
 * @property Users $user
 */
class ExecuterResponds extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'executer_responds';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['target_task_id'], 'required'],
            [['target_task_id', 'id_user'], 'integer'],
            [['dt_add'], 'safe'],
            [['notetext'], 'string'],
            [['target_task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tasks::className(), 'targetAttribute' => ['target_task_id' => 'id']],
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
            'id_user' => 'Id User',
            'dt_add' => 'Dt Add',
            'notetext' => 'Notetext',
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
     * @return ExecuterRespondsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ExecuterRespondsQuery(get_called_class());
    }
}
