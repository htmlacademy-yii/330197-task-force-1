<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "user_profile".
 *
 * @property int|null $iduser
 * @property string|null $address
 * @property string|null $birthday
 * @property string|null $about
 * @property string|null $avatar
 * @property string|null $phone
 * @property string|null $skype
 * @property string|null $telegram
 *
 * @property Users $iduser0
 */
class UserProfile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_profile';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['iduser'], 'integer'],
            [['birthday'], 'safe'],
            [['about'], 'string'],
            [['address', 'avatar', 'phone', 'skype', 'telegram'], 'string', 'max' => 255],
            [['iduser'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['iduser' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'iduser' => 'Iduser',
            'address' => 'Address',
            'birthday' => 'Birthday',
            'about' => 'About',
            'avatar' => 'Avatar',
            'phone' => 'Phone',
            'skype' => 'Skype',
            'telegram' => 'Telegram',
        ];
    }

    /**
     * Gets query for [[Iduser0]].
     *
     * @return \yii\db\ActiveQuery|UsersQuery
     */
    public function getIduser0()
    {
        return $this->hasOne(Users::className(), ['id' => 'iduser']);
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
