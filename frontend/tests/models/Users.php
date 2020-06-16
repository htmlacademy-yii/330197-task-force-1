<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string|null $fio
 * @property string|null $email
 * @property string|null $pass
 * @property string|null $dt_add
 *
 * @property ExecutersCategory[] $executersCategories
 * @property Portfolio[] $portfolios
 * @property Responds[] $responds
 * @property Tasks[] $tasks
 * @property Tasks[] $tasks0
 * @property UserPersonality[] $userPersonalities
 * @property UserProfile[] $userProfiles
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
            [['dt_add'], 'safe'],
            [['fio', 'email', 'pass'], 'string', 'max' => 255],
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
     * Gets query for [[Portfolios]].
     *
     * @return \yii\db\ActiveQuery|PortfolioQuery
     */
    public function getPortfolios()
    {
        return $this->hasMany(Portfolio::className(), ['idexecuter' => 'id']);
    }

    /**
     * Gets query for [[Responds]].
     *
     * @return \yii\db\ActiveQuery|RespondsQuery
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
     * @return \yii\db\ActiveQuery|UserPersonalityQuery
     */
    public function getUserPersonalities()
    {
        return $this->hasMany(UserPersonality::className(), ['iduser' => 'id']);
    }

    /**
     * Gets query for [[UserProfiles]].
     *
     * @return \yii\db\ActiveQuery|ExecutersCategoryQuery
     */
    public function getUserProfiles()
    {
        return $this->hasMany(UserProfile::className(), ['iduser' => 'id']);
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
