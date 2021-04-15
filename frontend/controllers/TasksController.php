<?php

namespace frontend\controllers;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use frontend\models\Categories;
use frontend\models\CategoriesFormNew;
use frontend\models\Tasks;
use frontend\models\Users;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use frontend\models\ExecuterResponds;
use frontend\models\FeedbackAboutExecuter;
use frontend\src\models\task;
use yii\widgets\ActiveForm;

class TasksController extends SecuredController
{   
    public function actionIndex()
    {
        $task_form = new CategoriesFormNew;
        $form_data = [];
        
        if (Yii::$app->request->getIsPost()) {
            $form_data = Yii::$app->request->post();
            $task_form->load($form_data);
        }

        $category = Categories::find()->select(['category', 'id'])->all();
        $categories = (ArrayHelper::map($category, 'id', 'category'));

        $categoryTask = Categories::find()->select(['category', 'id','icon'])->all();
        $categoryTasks = (ArrayHelper::map($categoryTask, 'category','icon', 'id'));
        
        $period = [ 'all_time' => 'За всё время',
                    'day' => 'За день',
                    'week' => 'За неделю',
                    'month' => 'За месяц'];

        $task = new Tasks;
        $parsed_data = $task->parse_data($form_data['CategoriesFormNew']);
        $tasks = $task->filter(5,$parsed_data);

        return $this->render('/site/tasks', ['categories' => $categories,
                                             'categoryTasks' => $categoryTasks,
                                             'period' => $period,
                                             'task_form' => $task_form,
                                             'tasks' => $tasks]);
    }

    public function actionView($id)
    {
        $userid = Yii::$app->user->getId();
        $user_profile = Users::findOne($userid);

        $respond_model = new ExecuterResponds;
        $feedback_model = new FeedbackAboutExecuter;

        $task = Tasks::findOne($id);
        if (!$task) {
            throw new NotFoundHttpException("Задача с ID $id не найдена");
        }
        $category = Categories::findOne($task->idcategory);

        $customer = Users::findOne($task->idcustomer);
        $customer_tasks_count = $customer->getCustomerTaskCount();

        $executers = $task->executerResponds;
        $files = $task->storedFiles;
        $executer_rate = [];
        $executer_info = [];
        $executers_id = [];

        foreach($executers as $value){
            $user = Users::findOne($value->id_user);
            $executer_rate[$value->id_user] = $user->getAvgRate();
            $executer_info[$value->id_user] = $user;
            $executers_id[] = $value->id_user;
        }

        $task_action = new Task;
        $idexecuter = empty($task->idexecuter) ? 0 : $task->idexecuter;

        $task_action = $task_action->get_actions($task->current_status, $task->idcustomer, $idexecuter, $userid, $user_profile->role);

        return $this->render('/site/view', ['task' => $task,
                                            'category' => $category,
                                            'customer' => $customer,
                                            'customer_tasks_count' => $customer_tasks_count,
                                            'executers' => $executers,
                                            'executer_rate' => $executer_rate,
                                            'executer_info' => $executer_info,
                                            'files' => $files,
                                            'user_profile' => $user_profile,
                                            'executers_id' => $executers_id,
                                            'task_action' => $task_action,
                                            'respond_model' => $respond_model,
                                            'feedback_model' => $feedback_model,
                                        ]);
    }

    public function actionResponds_action($idtask, $idexecuter, $action)
    {
        $userid = Yii::$app->user->getId();
        $task = Tasks::findone($idtask);

        if($task->idcustomer != $userid)
        {
            throw new ForbiddenHttpException("Это действие доступно только заказчику");
        }

        if($action === 'accept')
        {
            ExecuterResponds::accept($idtask, $idexecuter);

            $task->SetStatus(Task::STATUS_EXECUTE);
            $task->SetExecuter($idexecuter);

            Yii::$app->mailer->compose()
                    ->setFrom('test12330@hotmail.com')
                    ->setTo('test12330@hotmail.com')
                    ->setSubject("Заявка принята заказчиком")
                    ->setTextBody("Поздавляем! Ваш отклик на задачу \"".$task->title."\" принят заказчиком.")
                    ->send();
        }
        elseif($action === 'reject')
        {
            ExecuterResponds::reject($idtask, $idexecuter);
        }
        return Yii::$app->response->redirect(["/tasks/view/$idtask"]);
    }

    public function actionExecute($idtask){

        $userid = Yii::$app->user->getId();
        $user = Users::findone($userid);
        $user_respond = ExecuterResponds::checkRespond($idtask, $userid);
        $model = new ExecuterResponds;

        if($user->role !== 2 or !empty($user_respond))
        {
            throw new ForbiddenHttpException("Это действие доступно только исполнителю, который ещё не оставлял заявку для этой задачи.");
        }

        if (Yii::$app->request->getIsPost()) {
            $model->load(Yii::$app->request->post());

            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
        }

        if($model->validate()){
            $respond = new ExecuterResponds;
            $respond->target_task_id = $idtask;
            $respond->id_user = $userid;
            $respond->bid = $model->bid;
            $respond->notetext = $model->notetext;
            $respond->dt_add = date("Y-m-d H:i:s");
            $respond->save();
            return Yii::$app->response->redirect(["/tasks/view/$idtask"]);
        }
    }

    public function actionFeedback($idtask)
    {
        $userid = Yii::$app->user->getId();
        $user = Users::findone($userid);
        $user_feedback = FeedbackAboutExecuter::checkFeedback($idtask, $userid);
        $task = Tasks::findOne($idtask);

        if($task->idcustomer != $userid or !empty($user_feedback))
        {
            throw new ForbiddenHttpException("Задача завершена либо Вы не являетесь заказчиком.");
        }
        //Если исполнитель ещё не назначен, по задаче проставляем статус "отменена" без записи отзыва
        if(empty($task->idexecuter))
        {
            $task->SetStatus(Task::STATUS_CANCEL);
            return Yii::$app->response->redirect(["/tasks/view/$idtask"]);
        }

        $model = new FeedbackAboutExecuter;

        if (Yii::$app->request->getIsPost())
        {
            $model->load(Yii::$app->request->post());

            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
        }

        if($model->validate())
        {
            $feedback = new FeedbackAboutExecuter();
            $feedback->target_task_id = $idtask;
            $feedback->target_user_id = $task->idexecuter;
            $feedback->id_user = $userid;
            $feedback->rate = $model->rate;
            $feedback->dt_add = date("Y-m-d H:i:s");
            $feedback->description = $model->description;
            $feedback->save();
        }

        if($model->completion === 'yes' and !empty($task->idexecuter))
        {
            $task->SetStatus(Task::STATUS_DONE);
            return Yii::$app->response->redirect(["/tasks/view/$idtask"]);
        }

        if($model->completion === 'difficult' and !empty($task->idexecuter))
        {
            $task->SetStatus(Task::STATUS_FAIL);
            return Yii::$app->response->redirect(["/tasks/view/$idtask"]);
        }
    }

    public function actionDeny($idtask)
    {
        $userid = Yii::$app->user->getId();
        $task = Tasks::findOne($idtask);

        if($task->idexecuter != $userid)
        {
            throw new ForbiddenHttpException("У вас нет доступа для данного действия. От задачи может отказаться только исполнитель");
        }
        else
        {
            $task->SetStatus(Task::STATUS_FAIL);
            return Yii::$app->response->redirect(["/tasks/view/$idtask"]);
        }
    }
}
