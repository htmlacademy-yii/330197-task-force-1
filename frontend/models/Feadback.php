<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "feadback".
 *
 * @property int|null $idtask
 * @property int|null $rate
 * @property string|null $dt_add
 * @property string|null $description
 *
 * @property Tasks $idtask0
 */
class Feadback extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'feadback';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idtask', 'rate'], 'integer'],
            [['dt_add'], 'safe'],
            [['description'], 'string'],
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
            'rate' => 'Rate',
            'dt_add' => 'Dt Add',
            'description' => 'Description',
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
