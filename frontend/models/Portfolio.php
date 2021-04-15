<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "portfolio".
 *
 * @property int $idexecuter
 * @property string $photo
 * @property int $id
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
            [['idexecuter', 'photo'], 'required'],
            [['idexecuter'], 'integer'],
            [['photo'], 'string', 'max' => 255],
            [['idexecuter'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['idexecuter' => 'id']],
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
            'id' => 'ID',
        ];
    }

    /**
     * Gets query for [[Idexecuter0]].
     *
     * @return \yii\db\ActiveQuery|UsersQuery
     */
    public function getIdexecuter0()
    {
        return $this->hasOne(Users::class, ['id' => 'idexecuter']);
    }

    /**
     * {@inheritdoc}
     * @return PortfolioQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PortfolioQuery(get_called_class());
    }
}
