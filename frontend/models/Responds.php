<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "responds".
 *
 * @property int $idtask
 * @property int|null $idexecuter
 * @property string|null $dt_add
 * @property string|null $notetext
 *
 * @property Users $idexecuter0
 * @property Tasks $idtask0
 */
class Responds extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'responds';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idtask'], 'required'],
            [['idtask', 'idexecuter'], 'integer'],
            [['dt_add'], 'safe'],
            [['notetext'], 'string'],
            [['idtask'], 'exist', 'skipOnError' => true, 'targetClass' => Tasks::className(), 'targetAttribute' => ['idtask' => 'id']],
            [['idexecuter'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['idexecuter' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idtask' => 'Idtask',
            'idexecuter' => 'Idexecuter',
            'dt_add' => 'Dt Add',
            'notetext' => 'Notetext',
        ];
    }

    /**
     * Gets query for [[Idexecuter0]].
     *
     * @return \yii\db\ActiveQuery|ExecutersCategoryQuery
     */
    public function getIdexecuter0()
    {
        return $this->hasOne(Users::className(), ['id' => 'idexecuter']);
    }

    /**
     * Gets query for [[Idtask0]].
     *
     * @return \yii\db\ActiveQuery|ExecutersCategoryQuery
     */
    public function getIdtask0()
    {
        return $this->hasOne(Tasks::className(), ['id' => 'idtask']);
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
