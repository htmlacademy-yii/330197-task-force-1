<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $fio
 * @property string $email
 * @property string $pass
 * @property string|null $dt_add
 * @property int $role
 * @property string|null $address
 * @property string|null $birthday
 * @property string|null $about
 * @property string|null $avatar
 * @property string|null $phone
 * @property string|null $skype
 * @property string|null $telegram
 * @property string|null $last_update
 *
 * @property ExecutersCategory[] $executersCategories
 * @property Favorite[] $favorites
 * @property Favorite[] $favorites0
 * @property Feadback[] $feadbacks
 * @property Feadback[] $feadbacks0
 * @property Portfolio[] $portfolios
 * @property Responds[] $responds
 * @property Tasks[] $tasks
 * @property Tasks[] $tasks0
 * @property UserPersonality[] $userPersonalities
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fio', 'email', 'pass', 'role'], 'required'],
            [['dt_add', 'birthday', 'last_update'], 'safe'],
            [['role'], 'integer'],
            [['about'], 'string'],
            [['fio', 'email', 'pass', 'address', 'avatar', 'phone', 'skype', 'telegram'], 'string', 'max' => 255],
            [['email'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fio' => 'Fio',
            'email' => 'Email',
            'pass' => 'Pass',
            'dt_add' => 'Dt Add',
            'role' => 'Role',
            'address' => 'Address',
            'birthday' => 'Birthday',
            'about' => 'About',
            'avatar' => 'Avatar',
            'phone' => 'Phone',
            'skype' => 'Skype',
            'telegram' => 'Telegram',
            'last_update' => 'Last Update',
        ];
    }

    /**
     * Gets query for [[ExecutersCategories]].
     *
     * @return \yii\db\ActiveQuery|ExecutersCategoryQuery
     */
    public function getExecutersCategories()
    {
        return $this->hasMany(ExecutersCategory::className(), ['idexecuter' => 'id']);
    }

    /**
     * Gets query for [[Favorites]].
     *
     * @return \yii\db\ActiveQuery|FavoriteQuery
     */
    public function getFavorites()
    {
        return $this->hasMany(Favorite::className(), ['iduser' => 'id']);
    }

    /**
     * Gets query for [[Favorites0]].
     *
     * @return \yii\db\ActiveQuery|FavoriteQuery
     */
    public function getFavorites0()
    {
        return $this->hasMany(Favorite::className(), ['idexecuter' => 'id']);
    }

    /**
     * Gets query for [[Feadbacks]].
     *
     * @return \yii\db\ActiveQuery|FeadbackQuery
     */
    public function getFeadbacks()
    {
        return $this->hasMany(Feadback::className(), ['idexecuter' => 'id']);
    }

    /**
     * Gets query for [[Feadbacks0]].
     *
     * @return \yii\db\ActiveQuery|FeadbackQuery
     */
    public function getFeadbacks0()
    {
        return $this->hasMany(Feadback::className(), ['idcustomer' => 'id']);
    }

    /**
     * Gets query for [[Portfolios]].
     *
     * @return \yii\db\ActiveQuery|ExecutersCategoryQuery
     */
    public function getPortfolios()
    {
        return $this->hasMany(Portfolio::className(), ['idexecuter' => 'id']);
    }

    /**
     * Gets query for [[Responds]].
     *
     * @return \yii\db\ActiveQuery|ExecutersCategoryQuery
     */
    public function getResponds()
    {
        return $this->hasMany(Responds::className(), ['idexecuter' => 'id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery|ExecutersCategoryQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Tasks::className(), ['idcustomer' => 'id']);
    }

    /**
     * Gets query for [[Tasks0]].
     *
     * @return \yii\db\ActiveQuery|ExecutersCategoryQuery
     */
    public function getTasks0()
    {
        return $this->hasMany(Tasks::className(), ['idexecuter' => 'id']);
    }

    /**
     * Gets query for [[UserPersonalities]].
     *
     * @return \yii\db\ActiveQuery|ExecutersCategoryQuery
     */
    public function getUserPersonalities()
    {
        return $this->hasMany(UserPersonality::className(), ['iduser' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return UsersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UsersQuery(get_called_class());
    }
}
