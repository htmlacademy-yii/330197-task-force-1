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
            [['bid','notetext'], 'required'],
            [['target_task_id', 'id_user', 'bid'], 'integer'],
            [['dt_add'], 'safe'],
            [['notetext'], 'string'],
            [['target_task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tasks::class, 'targetAttribute' => ['target_task_id' => 'id']],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['id_user' => 'id']],
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
            'notetext' => 'Комментарий',
            'id' => 'ID',
            'bid' => 'Ваша цена',
        ];
    }

    /**
     * Gets query for [[TargetTask]].
     *
     * @return \yii\db\ActiveQuery|TasksQuery
     */
    public function getTargetTask()
    {
        return $this->hasOne(Tasks::class, ['id' => 'target_task_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery|UsersQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::class, ['id' => 'id_user']);
    }

    /**
     * {@inheritdoc}
     * @return ExecuterRespondsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ExecuterRespondsQuery(get_called_class());
    }

    /*Проставляем по указанноу отклику статус "accepted"*/
    public static function accept($idtask, $idexecuter)
    {
        return self::updateAll(['status' => 'accepted'], ['and',
                                                            ['=','target_task_id', $idtask],
                                                            ['=','id_user', $idexecuter],
                                                         ]);
    }

    /*Проставляем по указанноу отклику статус "rejected"*/
    public static function reject($idtask, $idexecuter)
    {
        return self::updateAll(['status' => 'rejected'], ['and',
                                                            ['=','target_task_id', $idtask],
                                                            ['=','id_user', $idexecuter],
                                                         ]);
    }

    /*Проверяем наличие оставленых откликов исполниелем на задачу*/
    public static function checkRespond($idtask, $idexecuter)
    {
        return self::find()->where(['and',['=','target_task_id',$idtask]
                                         ,['=','id_user',$idexecuter]
                                   ])->all();
    }
}
