<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "portfolio".
 *
 * @property int|null $idexecuter
 * @property string|null $photo
 *
 * @property Users $idexecuter0
 */
class Portfolio extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'portfolio';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idexecuter'], 'integer'],
            [['photo'], 'string', 'max' => 255],
            [['idexecuter'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['idexecuter' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idexecuter' => 'Idexecuter',
            'photo' => 'Photo',
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
     * {@inheritdoc}
     * @return ExecutersCategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ExecutersCategoryQuery(get_called_class());
    }
}
