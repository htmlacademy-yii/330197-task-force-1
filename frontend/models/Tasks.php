<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "tasks".
 *
 * @property int $id
 * @property int|null $idcustomer
 * @property int|null $idexecuter
 * @property string|null $title
 * @property string|null $description
 * @property int|null $idcategory
 * @property int|null $budget
 * @property string|null $dt_add
 * @property string|null $deadline
 * @property string|null $satatus
 * @property int|null $idcity
 * @property string|null $address
 * @property float|null $latitude
 * @property float|null $longitude
 * @property string|null $file_1
 * @property string|null $file_2
 * @property string|null $file_3
 *
 * @property Comments[] $comments
 * @property Feadback[] $feadbacks
 * @property Categories $idcategory0
 * @property Cities $idcity0
 * @property Users $idcustomer0
 * @property Users $idexecuter0
 * @property Responds[] $responds
 */
class Tasks extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idcustomer', 'idexecuter', 'idcategory', 'budget', 'idcity'], 'integer'],
            [['description'], 'string'],
            [['dt_add', 'deadline'], 'safe'],
            [['latitude', 'longitude'], 'number'],
            [['title', 'address', 'file_1', 'file_2', 'file_3'], 'string', 'max' => 255],
            [['satatus'], 'string', 'max' => 100],
            [['idcustomer'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['idcustomer' => 'id']],
            [['idexecuter'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['idexecuter' => 'id']],
            [['idcategory'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['idcategory' => 'id']],
            [['idcity'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['idcity' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'idcustomer' => 'Idcustomer',
            'idexecuter' => 'Idexecuter',
            'title' => 'Title',
            'description' => 'Description',
            'idcategory' => 'Idcategory',
            'budget' => 'Budget',
            'dt_add' => 'Dt Add',
            'deadline' => 'Deadline',
            'satatus' => 'Satatus',
            'idcity' => 'Idcity',
            'address' => 'Address',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
        ];
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery|CommentsQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comments::className(), ['idtask' => 'id']);
    }

    /**
     * Gets query for [[Feadbacks]].
     *
     * @return \yii\db\ActiveQuery|FeadbackQuery
     */
    public function getFeadbacks()
    {
        return $this->hasMany(Feadback::className(), ['idtask' => 'id']);
    }

    /**
     * Gets query for [[Idcategory0]].
     *
     * @return \yii\db\ActiveQuery|CategoriesQuery
     */
    public function getIdcategory0()
    {
        return $this->hasOne(Categories::className(), ['id' => 'idcategory']);
    }

    /**
     * Gets query for [[Idcity0]].
     *
     * @return \yii\db\ActiveQuery|CitiesQuery
     */
    public function getIdcity0()
    {
        return $this->hasOne(Cities::className(), ['id' => 'idcity']);
    }

    /**
     * Gets query for [[Idcustomer0]].
     *
     * @return \yii\db\ActiveQuery|UsersQuery
     */
    public function getIdcustomer0()
    {
        return $this->hasOne(Users::className(), ['id' => 'idcustomer']);
    }

    /**
     * Gets query for [[Idexecuter0]].
     *
     * @return \yii\db\ActiveQuery|UsersQuery
     */
    public function getIdexecuter0()
    {
        return $this->hasOne(Users::className(), ['id' => 'idexecuter']);
    }

    /**
     * Gets query for [[Responds]].
     *
     * @return \yii\db\ActiveQuery|RespondsQuery
     */
    public function getResponds()
    {
        return $this->hasMany(Responds::className(), ['idtask' => 'id']);
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
