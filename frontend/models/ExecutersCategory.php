<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "executers_category".
 *
 * @property int $idexecuter
 * @property int $idcategory
 *
 * @property Categories $idcategory0
 * @property Users $idexecuter0
 */
class ExecutersCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'executers_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idexecuter', 'idcategory'], 'required'],
            [['idexecuter', 'idcategory'], 'integer'],
            [['idexecuter'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['idexecuter' => 'id']],
            [['idcategory'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::class, 'targetAttribute' => ['idcategory' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idexecuter' => 'Idexecuter',
            'idcategory' => 'Idcategory',
        ];
    }

    /**
     * Gets query for [[Idcategory0]].
     *
     * @return \yii\db\ActiveQuery|ExecutersCategoryQuery
     */
    public function getIdcategory()
    {
        return $this->hasOne(Categories::class, ['id' => 'idcategory']);
    }

    /**
     * Gets query for [[Idexecuter0]].
     *
     * @return \yii\db\ActiveQuery|ExecutersCategoryQuery
     */
    public function getIdexecuter()
    {
        return $this->hasOne(Users::class, ['id' => 'idexecuter']);
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
