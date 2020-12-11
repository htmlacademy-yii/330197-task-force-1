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
 * @property CommentsForTask[] $commentsForTasks
 * @property ExecuterResponds[] $executerResponds
 * @property ExecutersCategory[] $executersCategories
 * @property Favorite[] $favorites
 * @property Favorite[] $favorites0
 * @property FeedbackAboutExecuter[] $feedbackAboutExecuters
 * @property Portfolio[] $portfolios
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

    public function parse_data($form_data)
    {
        // Представляем, данные полученные из формы в удобном виде
        if($form_data['category']){
            $form_data['category'] = implode(",",$form_data['category']);
        }
        return $form_data;
    }

    //Выводим список исполнителей, которые принадлежат к выбранной категории
    private function getExequtersByCategory($categories=null){
        $idexecuters = ExecutersCategory::find()->distinct()->select(['idexecuter'])->from('executers_category');
        if($categories){
            $idexecuters = $idexecuters->andWhere("idcategory in ($categories)");
        }
        $idexecuters = $idexecuters->all();

        //Записываем в масив список всех исполнителей с нужной категорией
        foreach($idexecuters as $value){
            $array_execurters[] = $value['idexecuter'];
        }
        $array_execurters = implode(",",$array_execurters);

        return $array_execurters;
    }

    public function search($form_data = null){
        $id_executers = $this->getExequtersByCategory($form_data['category']);

        $query = self::find();
        $query = $query->from(['users u'])
                        ->joinWith('feedbackAboutExecuters f', true, 'LEFT JOIN' )
                        ->joinWith('tasks t', true, 'LEFT JOIN')
                        ->where('u.role = 2')
                        ->andWhere("u.id in ($id_executers)");

        if($form_data['search']){
            $query = $query->andWhere(['like', 'u.fio', $form_data['search']]);
        } else {
            if($form_data['free']){
                $query = $query->andWhere(['not in','t.current_status', ['new','in_progress']]);
            }
            if($form_data['online']){
                $query = $query->andWhere("u.last_update >= date_sub(NOW(),INTERVAL 30 MINUTE)");
            }
            if($form_data['feedback']){
                $query = $query->andWhere("f.target_user_id is not null");
            }
            if($form_data['favorite']){
                $query = $query->andWhere("u.id in (select distinct favorite_user from favorite)");
            }
        }

        $query = $query->groupBy(['u.id','u.fio', 'u.dt_add', 'u.last_update', 'u.avatar', 'u.about', 'u.views']);
        if($form_data['s'] === 'date'){
            $query = $query->orderBy(['u.dt_add'=> SORT_DESC]);
        }
        if($form_data['s'] === 'rate'){
            $query = $query->orderBy(['avg(ifnull(f.rate,0))'=> SORT_DESC]);
        }
        if($form_data['s'] === 'orders'){
            $query = $query->orderBy(['COUNT(t.id)'=> SORT_DESC]);
        }
        if($form_data['s'] === 'favor'){
            $query = $query->orderBy(['u.views'=> SORT_DESC]);
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

    //Формируем массив с рейтингом пользователей и количеством отзывов
    public function getRates($users){
        $id = 0;
        $array = [];
        $r = [];
        $f = [];
        $rates = [];
        foreach($users as $user){
            $id = $user->id;

            foreach ($user->feedbackAboutExecuters as $feedback) {
                $array['rate'][$id][] = $feedback->rate;
                $array['feedback_id'][$id][] = $feedback->id;
            }

            $r = array_filter($array['rate'][$id]);
            $f = array_filter($array['feedback_id'][$id]);

            $rates['rate'][$id] = round(array_sum($r)/count($r),2);
            $rates['feedbacks'][$id] = count($f);
        }

        return $rates;
    }

     //Формируем массив с количеством выполненных заданий
    public function getTaskCount($users){
        $id = 0;
        $array = [];
        $t = [];
        $user_tasks = [];
        foreach($users as $user){
            $id = $user->id;
            foreach ($user->tasks as $task) {
                $array[$id][] = $task->id;
            }
            $user_tasks[$id] = count($array[$id]);
        }

        return $user_tasks;
    }

}
