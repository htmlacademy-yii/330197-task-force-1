<?php

namespace frontend\models;

use Yii;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

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
 * @property int|null $views
 *
 * @property Cities $city
 * @property CommentsForTask[] $commentsForTasks
 * @property ExecuterResponds[] $executerResponds
 * @property ExecutersCategory[] $executersCategories
 * @property Favorite[] $favorites
 * @property Favorite[] $favorites0
 * @property FeedbackAboutExecuter[] $feedbackAboutExecuters
 * @property Portfolio[] $portfolios
 * @property Tasks[] $tasks
 * @property DoneTasks[] $doneTasks
 * @property UserPersonality[] $userPersonalities
 */

class Users extends \yii\db\ActiveRecord implements IdentityInterface
{
    public $password_repeat;

    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
    }

    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
    }

    public function validatePassword($password)
    {
        return \Yii::$app->security->validatePassword($password, $this->pass);
    }

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
            [['role', 'views'], 'integer'],
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
            'views' => 'Views',
        ];
    }
    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery|CitiesQuery
     */
    public function getCity()
    {
        return $this->hasOne(Cities::class, ['id' => 'city_id']);
    }

    /**
     * Gets query for [[CommentsForTasks]].
     *
     * @return \yii\db\ActiveQuery|CommentsForTaskQuery
     */
    public function getCommentsForTasks()
    {
        return $this->hasMany(CommentsForTask::class, ['id_user' => 'id']);
    }

    /**
     * Gets query for [[ExecuterResponds]].
     *
     * @return \yii\db\ActiveQuery|ExecuterRespondsQuery
     */
    public function getExecuterResponds()
    {
        return $this->hasMany(ExecuterResponds::class, ['id_user' => 'id']);
    }

    /**
     * Gets query for [[ExecutersCategories]].
     *
     * @return \yii\db\ActiveQuery|ExecutersCategoryQuery
     */
    public function getExecutersCategories()
    {
        return $this->hasMany(ExecutersCategory::class, ['idexecuter' => 'id']);
    }

    public function getCategories()
    {
        return $this->hasMany(Categories::class, ['id' => 'idcategory'])
                    ->viaTable('executers_category', ['idexecuter' => 'id']);
    }

    /**
     * Gets query for [[Favorites]].
     *
     * @return \yii\db\ActiveQuery|FavoriteQuery
     */
    public function getFavorites()
    {
        return $this->hasMany(Favorite::class, ['iduser' => 'id']);
    }

    //Выводим список исполнителей, которые находятся в избранном для текущего пользователя
    public function getChoicest(): FavoriteQuery
    {
        return $this->hasMany(Favorite::class, ['favorite_user' => 'id']);
    }

    /**
     * Gets query for [[FeedbackAboutExecuters]].
     *
     * @return \yii\db\ActiveQuery|FeedbackAboutExecuterQuery
     */
    public function getFeedbackAboutExecuters()
    {
        return $this->hasMany(FeedbackAboutExecuter::class, ['target_user_id' => 'id']);
    }

    /**
     * Gets query for [[Portfolios]].
     *
     * @return \yii\db\ActiveQuery|ExecutersCategoryQuery
     */
    public function getPortfolios()
    {
        return $this->hasMany(Portfolio::class, ['idexecuter' => 'id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery|TasksQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Tasks::class, ['idexecuter' => 'id']);
    }

    /**
     * Gets query for [[UserPersonalities]].
     *
     * @return \yii\db\ActiveQuery|ExecutersCategoryQuery
     */
    public function getUserPersonalities()
    {
        return $this->hasMany(UserPersonality::class, ['iduser' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return UsersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UsersQuery(get_called_class());
    }

    //Выводим список исполнителей, которые принадлежат к выбранной категории
    private function getExequtersByCategory($categories=null){
        $idexecuters = ExecutersCategory::find()->distinct()->select(['idexecuter']);

        if($categories){
            $idexecuters = $idexecuters->andWhere(['in', 'idcategory', $categories]);
        }
        $idexecuters = $idexecuters->all();

        return (ArrayHelper::getColumn($idexecuters, 'idexecuter'));
    }

    public function search($form_data = null){

        $data = isset($form_data['category']) ? $form_data['category'] : null;
        $id_executers = $this->getExequtersByCategory($data);

        $query = self::find();
        $query = $query->joinWith('feedbackAboutExecuters f', true, 'LEFT JOIN' )
                        ->where(['=','users.role',2])
                        ->andWhere(['in','users.id',$id_executers]);

        if($form_data['search']){
            $query = $query->andWhere(['like', 'users.fio', $form_data['search']]);
        } else {
            if($form_data['free']){
                $query = $query->joinWith('tasks')
                                ->andWhere(['not in','tasks.current_status', ['new','in_progress']]);
            }
            if($form_data['online']){
                $date = date_create(date('Y-m-d H:i:s'));
                date_sub($date,date_interval_create_from_date_string('30 minute'));
                $date = date_format($date,'Y-m-d H:i:s');

                $query = $query->andWhere(['>=','users.last_update',$date]);
            }
            if($form_data['feedback']){
                $query = $query->andWhere(['is not','f.target_user_id',null]);
            }
            if($form_data['favorite']){
                $current_user_id = 1;
                $query = $query->joinWith('choicest')
                                ->andWhere(['=','iduser',$current_user_id]);
            }
        }

        $query = $query->groupBy(['users.id','users.fio', 'users.dt_add', 'users.last_update', 'users.avatar', 'users.about', 'users.views']);
        if($form_data['s'] === 'date'){
            $query = $query->orderBy(['users.dt_add'=> SORT_DESC]);
        }
        if($form_data['s'] === 'rate'){
            $query = $query->orderBy(['avg(ifnull(f.rate,0))'=> SORT_DESC]);
        }
        if($form_data['s'] === 'orders'){
             $query = $query->joinWith(['tasks' => static function (TasksQuery $query) {
                                            return $query->onCondition(['=','tasks.current_status','done']);
                                        }])
                            ->orderBy(['COUNT(tasks.id)'=> SORT_DESC]);
        }
        if($form_data['s'] === 'favor'){
            $query = $query->orderBy(['users.views'=> SORT_DESC]);
        }

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);

        $users = $provider->getModels();

        return $users;
    }

    //Возвращает полную информацию всех отзывов о пользователе по его id
    public function getFeedbackFullInfo(){
        $user = FeedbackAboutExecuter::find()->where(['=','target_user_id',$this->id])->all();
        if(!empty($user)){
            foreach($user as $value){
                $task = Tasks::findOne($value->target_task_id);
                $customer = Users::findOne($value->id_user);

                $feedback[$value->id]['task_title'] = $task->title;
                $feedback[$value->id]['task_id'] = $task->id;
                $feedback[$value->id]['owner_fio'] = $customer->fio;
                $feedback[$value->id]['owner_avatar'] = $customer->avatar;
                $feedback[$value->id]['rate'] = $value->rate;
                $feedback[$value->id]['description'] = $value->description;
                $feedback[$value->id]['dt_add'] = $value->dt_add;

                if($value->rate <= 3)
                {
                    $feedback[$value->id]['rate_text'] = 'three';
                } else {
                    $feedback[$value->id]['rate_text'] = 'five';
                }
            }
        }
        return $feedback;
    }

    //Выводим количество задач открытых заказчиком по его id
    public function getCustomerTaskCount(){
        return Tasks::find()->where(['=','idcustomer', $this->id])->count();
    }

    //Выводим количество отзывов про исполнителя по его id
    public function getExecutersFeedbackCount(){
        return FeedbackAboutExecuter::find()->where(['=','target_user_id',$this->id])->count();
    }

    //Выводим количество отзывов про исполнителя по его id
    public function getAvgRate(){
        return round(FeedbackAboutExecuter::find()->where(['=','target_user_id',$this->id])->average('rate'),2);
    }

    //Формируем массив с количеством выполненных заданий исполнителем
    public function getExecuterTaskCount(){
        $taskCount = self::find()
                ->joinWith('tasks t', true, 'INNER JOIN')
                ->where(['=','users.id',$this->id])
                ->andWhere(['=','t.current_status','done'])
                ->count();
        return $taskCount;
    }

    //Формируем массив с названием категорий для исполнителя по его id
    public function getArrayCaterories(){
        $query = self::find()
                ->joinWith('executersCategories ec', true, 'INNER JOIN')
                ->joinWith('categories c', true, 'INNER JOIN')
                ->where(['=','ec.idexecuter', $this->id]);
        $provider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $user = $provider->getModels();
        if($user[0]->categories){
            foreach($user[0]->categories as $category){
                $user_categories[] = $category["category"];
            }
            return $user_categories;
        } else {
            return false;
        }
    }

    //Выводим портфолио исполнителя по его id
    public function getPortfolio(){
        return Portfolio::find()->where(['=','idexecuter', $this->id])->all();
    }

}
