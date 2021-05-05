<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "user_personality".
 *
 * @property int $iduser
 * @property int $idnotice
 *
 * @property PersonNotice $idnotice0
 * @property Users $iduser0
 */
class UserPersonality extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_personality';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['iduser', 'idnotice'], 'required'],
            [['iduser', 'idnotice'], 'integer'],
            [['iduser'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['iduser' => 'id']],
            [['idnotice'], 'exist', 'skipOnError' => true, 'targetClass' => PersonNotice::class, 'targetAttribute' => ['idnotice' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'iduser' => 'Iduser',
            'idnotice' => 'Idnotice',
        ];
    }

    /**
     * Gets query for [[Idnotice0]].
     *
     * @return \yii\db\ActiveQuery|ExecutersCategoryQuery
     */
    public function getIdnotice0()
    {
        return $this->hasOne(PersonNotice::class, ['id' => 'idnotice']);
    }

    /**
     * Gets query for [[Iduser0]].
     *
     * @return \yii\db\ActiveQuery|ExecutersCategoryQuery
     */
    public function getIduser0()
    {
        return $this->hasOne(Users::class, ['id' => 'iduser']);
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
