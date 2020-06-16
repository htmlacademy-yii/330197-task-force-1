<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "comments".
 *
 * @property int|null $idtask
 * @property string|null $dt_add
 * @property int|null $rate
 * @property string|null $notetext
 *
 * @property Tasks $idtask0
 */
class Comments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idtask', 'rate'], 'integer'],
            [['dt_add'], 'safe'],
            [['notetext'], 'string'],
            [['idtask'], 'exist', 'skipOnError' => true, 'targetClass' => Tasks::className(), 'targetAttribute' => ['idtask' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idtask' => 'Idtask',
            'dt_add' => 'Dt Add',
            'rate' => 'Rate',
            'notetext' => 'Notetext',
        ];
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
