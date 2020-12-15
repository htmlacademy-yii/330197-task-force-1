<?php

namespace frontend\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "tasks".
 *
 * @property int $id
 * @property int $idcustomer
 * @property int|null $idexecuter
 * @property string $title
 * @property string|null $description
 * @property int $idcategory
 * @property int|null $budget
 * @property string|null $dt_add
 * @property string|null $deadline
 * @property string|null $current_status
 * @property int|null $idcity
 * @property string|null $address
 * @property float|null $latitude
 * @property float|null $longitude
 *
 * @property CommentsForTask[] $commentsForTasks
 * @property ExecuterResponds[] $executerResponds
 * @property Favorite[] $favorites
 * @property FeedbackAboutExecuter[] $feedbackAboutExecuters
 * @property Categories $idcategory
 * @property Cities $idcity
 * @property Users $idcustomer
 * @property Users $idexecuter
 * @property StoredFiles[] $storedFiles
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
            [['idcustomer', 'title', 'idcategory'], 'required'],
            [['idcustomer', 'idexecuter', 'idcategory', 'budget', 'idcity'], 'integer'],
            [['description'], 'string'],
            [['dt_add', 'deadline'], 'safe'],
            [['latitude', 'longitude'], 'number'],
            [['title', 'address'], 'string', 'max' => 255],
            [['current_status'], 'string', 'max' => 100],
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
            'current_status' => 'Current Status',
            'idcity' => 'Idcity',
            'address' => 'Address',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
        ];
    }

    /**
     * Gets query for [[CommentsForTasks]].
     *
     * @return \yii\db\ActiveQuery|CommentsForTaskQuery
     */
    public function getCommentsForTasks()
    {
        return $this->hasMany(CommentsForTask::className(), ['target_task_id' => 'id']);
    }

    /**
     * Gets query for [[ExecuterResponds]].
     *
     * @return \yii\db\ActiveQuery|ExecuterRespondsQuery
     */
    public function getExecuterResponds()
    {
        return $this->hasMany(ExecuterResponds::className(), ['target_task_id' => 'id']);
    }

    /**
     * Gets query for [[Favorites]].
     *
     * @return \yii\db\ActiveQuery|FavoriteQuery
     */
    public function getFavorites()
    {
        return $this->hasMany(Favorite::className(), ['favorite_task' => 'id']);
    }

    /**
     * Gets query for [[FeedbackAboutExecuters]].
     *
     * @return \yii\db\ActiveQuery|FeedbackAboutExecuterQuery
     */
    public function getFeedbackAboutExecuters()
    {
        return $this->hasMany(FeedbackAboutExecuter::className(), ['target_task_id' => 'id']);
    }

    /**
     * Gets query for [[Idcategory]].
     *
     * @return \yii\db\ActiveQuery|ExecutersCategoryQuery
     */
    public function getIdcategory()
    {
        return $this->hasOne(Categories::className(), ['id' => 'idcategory']);
    }

    /**
     * Gets query for [[Idcity]].
     *
     * @return \yii\db\ActiveQuery|ExecutersCategoryQuery
     */
    public function getIdcity()
    {
        return $this->hasOne(Cities::className(), ['id' => 'idcity']);
    }

    /**
     * Gets query for [[Idcustomer]].
     *
     * @return \yii\db\ActiveQuery|UsersQuery
     */
    public function getIdcustomer()
    {
        return $this->hasOne(Users::className(), ['id' => 'idcustomer']);
    }

    /**
     * Gets query for [[Idexecuter]].
     *
     * @return \yii\db\ActiveQuery|UsersQuery
     */
    public function getIdexecuter()
    {
        return $this->hasOne(Users::className(), ['id' => 'idexecuter']);
    }

    /**
     * Gets query for [[StoredFiles]].
     *
     * @return \yii\db\ActiveQuery|StoredFilesQuery
     */
    public function getStoredFiles()
    {
        return $this->hasMany(StoredFiles::className(), ['idtask' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return TasksQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TasksQuery(get_called_class());
    }

    public function parse_data($form_data = null)
    {
        // Представляем, данные полученные из формы в удобном виде
        if($form_data['no_executers']){
            $form_data['no_executers'] = true;
        }
        if($form_data['no_address']){
            $form_data['no_address'] = true;
        }
        if($form_data['period']){
            switch ($form_data['period']) {
                case 'day':
                    $form_data['period'] = date('Y-m-d',time()-86400);
                    break;
                case 'week':
                    $form_data['period'] = date('Y-m-d',time()-86400*7);
                    break;
                case 'month':
                    $form_data['period'] = date('Y-m-d',time()-86400*30);
                    break;
                default:
                    $form_data['period'] = false;
                    break;
            }
        }

        return $form_data;
    }

    public static function filter ($form_data = null){

        $query = self::find();
        $query = $query->from(['tasks t'])
                        ->joinWith('executerResponds er', true, 'LEFT JOIN')
                        ->where(['in','current_status', ['new']]);

        //Подключаем переданные фильтры через форму
        if($form_data['category']){
            $query = $query->andWhere(['in','idcategory',$form_data['category']]);
        }
        if($form_data['no_executers']){
            $query = $query->andWhere(['is','er.target_task_id', null]);
        }
        if($form_data['no_address']){
            $query = $query->andWhere(['or',['is','t.latitude', null],['is','t.longitude', null]]);
        }
        if($form_data['period']){
            $query = $query->andWhere(['>=','t.dt_add',$form_data['period']]);
        }
        if($form_data['search']){
            $query = $query->andWhere(['like', 'title', $form_data['search']]);
        }

        $query = $query->orderBy(['t.dt_add' => SORT_DESC]);

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);
        $tasks = $provider->getModels();

        return $tasks;
    }
}
