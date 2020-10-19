<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "feadback".
 *
 * @property int $idtask
 * @property int|null $idexecuter
 * @property int|null $idcustomer
 * @property int|null $rate
 * @property string|null $dt_add
 * @property string|null $description
 *
 * @property Users $idcustomer0
 * @property Users $idexecuter0
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
            [['idtask'], 'required'],
            [['idtask', 'idexecuter', 'idcustomer', 'rate'], 'integer'],
            [['dt_add'], 'safe'],
            [['description'], 'string'],
            [['idtask'], 'exist', 'skipOnError' => true, 'targetClass' => Tasks::className(), 'targetAttribute' => ['idtask' => 'id']],
            [['idexecuter'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['idexecuter' => 'id']],
            [['idcustomer'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['idcustomer' => 'id']],
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
            'idcustomer' => 'Idcustomer',
            'rate' => 'Rate',
            'dt_add' => 'Dt Add',
            'description' => 'Description',
        ];
    }

    /**
     * Gets query for [[Idcustomer0]].
     *
     * @return \yii\db\ActiveQuery|ExecutersCategoryQuery
     */
    public function getIdcustomer0()
    {
        return $this->hasOne(Users::className(), ['id' => 'idcustomer']);
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
     * @return FeadbackQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FeadbackQuery(get_called_class());
    }
}
