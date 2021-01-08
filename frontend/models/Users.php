<?php

namespace frontend\models;

use Yii;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

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
        return $this->hasOne(Cities::className(), ['id' => 'city_id']);
    }

    /**
     * Gets query for [[CommentsForTasks]].
     *
     * @return \yii\db\ActiveQuery|CommentsForTaskQuery
     */
    public function getCommentsForTasks()
    {
        return $this->hasMany(CommentsForTask::className(), ['id_user' => 'id']);
    }

    /**
     * Gets query for [[ExecuterResponds]].
     *
     * @return \yii\db\ActiveQuery|ExecuterRespondsQuery
     */
    public function getExecuterResponds()
    {
        return $this->hasMany(ExecuterResponds::className(), ['id_user' => 'id']);
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

    public function getCategories()
    {
        return $this->hasMany(Categories::className(), ['id' => 'idcategory'])
                    ->viaTable('executers_category', ['idexecuter' => 'id']);
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
     * Gets query for [[FeedbackAboutExecuters]].
     *
     * @return \yii\db\ActiveQuery|FeedbackAboutExecuterQuery
     */
    public function getFeedbackAboutExecuters()
    {
        return $this->hasMany(FeedbackAboutExecuter::className(), ['target_user_id' => 'id']);
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
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery|TasksQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Tasks::className(), ['idexecuter' => 'id']);
    }

    // /**
    //  * Gets query for [[Tasks]].
    //  *
    //  * @return \yii\db\ActiveQuery|TasksQuery
    //  */
    // public function getDoneTasks()
    // {
    //     return $this->hasMany(Tasks::className(), ['idexecuter' => 'id'])->where(['=','current_status','done']);
    // }

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

    //Выводим список исполнителей, которые принадлежат к выбранной категории
    private function getExequtersByCategory($categories=null){
        $idexecuters = ExecutersCategory::find()->distinct()->select(['idexecuter']);

        if($categories){
            $idexecuters = $idexecuters->andWhere(['in', 'idcategory', $categories]);
        }
        $idexecuters = $idexecuters->all();

        //Записываем в масив список всех исполнителей с нужной категорией
        foreach($idexecuters as $value){
            $array_execurters[] = $value['idexecuter'];
        }
        return $array_execurters;
    }

    //Выводим список исполнителей, которые находятся в избранном для текущего пользователя
    private function getFavoriteUser($id){
        $favorite = Favorite::find()->distinct()->select(['favorite_user'])->andWhere(['=','iduser',$id])->all();

        //Записываем в масив список всех исполнителей из избранного
        foreach($favorite as $user){
            $favorite_users[] = $user['favorite_user'];
        }
        return $favorite_users;
    }

    public function search($form_data = null){

        $id_executers = $this->getExequtersByCategory($form_data['category']);

        $query = self::find();
        $query = $query->joinWith('feedbackAboutExecuters f', true, 'LEFT JOIN' )
                        ->joinWith('tasks t', true, 'LEFT JOIN')
                        // ->joinWith(['tasks t2' => function (TasksQuery $query) {
                        //                     return $query
                        //                         ->andWhere(['=', 't2.current_status','done']);
                        //                 }])
                        // ->onCondition(['=','t.current_status','done'])
                        // ->joinWith(['doneTasks t2', true, 'LEFT JOIN'])
                        ->where(['=','users.role',2])
                        ->andWhere(['in','users.id',$id_executers]);

        if($form_data['search']){
            $query = $query->andWhere(['like', 'users.fio', $form_data['search']]);
        } else {
            if($form_data['free']){
                $query = $query->andWhere(['not in','t.current_status', ['new','in_progress']]);
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
                $favorite_users = $this->getFavoriteUser($current_user_id);
                $query = $query->andWhere(['in','users.id',$favorite_users]);
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
            $query = $query->orderBy(['COUNT(t.id)'=> SORT_DESC]);
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

    //Формируем дополнительные данные для ответа
    public function getAddition($users){
        // Для каждого исполнителея выводим массив с idcategory работ которые они выполняют
        foreach($users as $user){
            $i= $user['id'];
            $iduser = Users::findOne($i);
            $idexecuters = $iduser->executersCategories;
            foreach($idexecuters as $value){
                $array[$i]['idcategories'][] = $value->idcategory;
            }
        }
        return $array;
    }

    //Возвращает средний рейтинг исполнителя по его id
    public function getAvgRate($id){
        $user = Users::findOne($id);

        if(count($user->feedbackAboutExecuters) >1){
            foreach ($user->feedbackAboutExecuters as $value) {
                $array[] = $value->rate;
                $r = array_filter($array);
                $avg_rate = round(array_sum($r)/count($r),2);
            }
        } else {
            $avg_rate = $value->rate;
        }
        return $avg_rate;
    }

    //Возвращает количество отзывов о пользователе по его id
    public function getCountFeedback($id){
        $user = Users::findOne($id);

        if(count($user->feedbackAboutExecuters) >0){
            foreach ($user->feedbackAboutExecuters as $value) {
                $array[] = $value->id;
                $r = array_filter($array);
                $count_feedbacks = count($r);
            }
        } else {
            $count_feedbacks = 0;
        }
        return $count_feedbacks;
    }

    //Возвращает полную информацию всех отзывов о пользователе по его id
    public function getFeedbackFullInfo($executer_id){
        $user = Users::findOne($executer_id);

        if(!empty($user->feedbackAboutExecuters)){
            foreach($user->feedbackAboutExecuters as $value){
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
    public static function getCustomerTaskCount($customer_id){
        return Tasks::find()->where(['=','idcustomer', $customer_id])->count();
    }

    //Формируем массив с количеством выполненных заданий исполнителем
    public function getExecuterTaskCount($executer_id){
        $taskCount = self::find()
                ->joinWith('tasks t', true, 'INNER JOIN')
                ->where("users.id=$executer_id")
                ->andWhere(['=','t.current_status','done'])
                ->count();
        return $taskCount;
    }

    //Формируем массив с названием категорий для исполнителя по его id
    public function getArrayCaterories($executer_id){
        $query = self::find()
                ->joinWith('executersCategories ec', true, 'INNER JOIN')
                ->joinWith('categories c', true, 'INNER JOIN')
                ->where(['=','ec.idexecuter', $executer_id]);
        $provider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $user = $provider->getModels();

        foreach($user[0]->categories as $category){
            $user_categories[] = $category["category"];
        }
        return $user_categories;
    }

    //Формируем массив с названием категорий для исполнителя по его id
    public function getArrayPortfolio($executer_id){
        $query = self::find()
                ->joinWith('portfolios p', true, 'INNER JOIN')
                ->where(['=','p.idexecuter', $executer_id]);
        $provider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $user = $provider->getModels();

        if(!empty($user[0]->portfolios)){
            foreach($user[0]->portfolios as $photo){
                $user_portfolio[] = $photo["photo"];
            }
        }
        return $user_portfolio;
    }

}
