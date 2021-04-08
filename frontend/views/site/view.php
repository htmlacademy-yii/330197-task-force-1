<?php
/* @var $tasks \frontend\controllers\TasksController*/
/* @var $categories \frontend\controllers\TasksController*/

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ActiveField;
?>
    <main class="page-main">
        <div class="main-container page-container">
            <section class="content-view">
                <div class="content-view__card">
                    <div class="content-view__card-wrapper">
                        <div class="content-view__header">
                            <div class="content-view__headline">
                                <h1><?= $task->title?></h1>
                                <span>Размещено в категории
                                    <a href="#" class="link-regular"><?= $category->category?></a>
                                    <?= Yii::$app->formatter->asRelativeTime($task->dt_add) ?></span>
                            </div>
                            <b class="new-task__price new-task__price--<?= $category->icon?> content-view-price"><?= $task->budget?><b> ₽</b></b>
                            <div class="new-task__icon new-task__icon--<?= $category->icon?> content-view-icon"></div>
                        </div>
                        <div class="content-view__description">
                            <h3 class="content-view__h3">Общее описание</h3>
                            <p>
                                <?= $task->description?>
                            </p>
                        </div>
                         <?php if(!empty($files)):?>
                        <div class="content-view__attach">
                            <h3 class="content-view__h3">Вложения</h3>
                            <?php foreach($files as $file):?>
                                <a href="<?=Url::to(['/user_files/'.$file['file_path']])?>"><?=$file['file_path']?></a>
                            <?php endforeach;?>
                        </div>
                        <?php endif; ?>
                        <div class="content-view__location">
                            <h3 class="content-view__h3">Расположение</h3>
                            <div class="content-view__location-wrapper">
                                <div class="content-view__map">
                                    <a href="#"><img src="/img/map.jpg" width="361" height="292"
                                                     alt="Москва, Новый арбат, 23 к. 1"></a>
                                </div>
                                <div class="content-view__address">
                                    <span class="address__town">Москва</span><br>
                                    <span>Новый арбат, 23 к. 1</span>
                                    <p>Вход под арку, код домофона 1122</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if($task_action):?>
                    <div class="content-view__action-buttons">
                        <?php if($task_action->inner_name === 'cancel' or $task_action->inner_name === 'done'):?>
                        <button class="button button__big-color request-button open-modal" type="button" data-for="complete-form">Завершить</button>
                        <?php endif;?>

                        <?php if($task_action->inner_name === 'execute' and !in_array($user_profile->id,$executers_id)):?>
                        <button class=" button button__big-color response-button open-modal" type="button" data-for="response-form">Откликнуться</button>
                        <?php endif;?>

                        <?php if($task_action->inner_name === 'deny'):?>
                        <button class="button button__big-color refusal-button open-modal" type="button" data-for="refuse-form">Отказаться</button>
                        <?php endif;?>
                    </div>
                    <?php endif;?>
                </div>
                <?php if(count($executers)>0 and ($user_profile->id === $customer->id or in_array($user_profile->id,$executers_id))):?>
                <div class="content-view__feedback">
                    <h2>Отклики 
                    <?php if($user_profile->id === $customer->id): ?>
                        <span>(<?=count($executers)?>)</span>
                    <?php endif; ?>
                    </h2>
                    <div class="content-view__feedback-wrapper">
                        <?php foreach($executers as $executer):?>
                        <?php if($user_profile->id === $customer->id or $user_profile->id === $executer->id_user):?>
                        <div class="content-view__feedback-card">
                            <div class="feedback-card__top">
                                <a href="<?=Url::to(['/users/view/'.$executer->id_user])?>"><?= Yii::$app->formatter->asImage(isset($executer_info[$executer->id_user]->avatar) ? '/img/'.$executer_info[$executer->id_user]->avatar : '/img/upload.png',['width'=>"55", 'height'=>"55", 'alt'=>"Аватар"]) ?></a>
                                <div class="feedback-card__top--name">
                                    <p><a href="<?=Url::to(['/users/view/'.$executer->id_user])?>" class="link-regular"><?=$executer_info[$executer->id_user]->fio?></a></p>
                                    <?php for($i=0; $i<round($executer_rate[$executer->id_user]); $i++): ?>
                                        <span></span>
                                    <?php endfor;?>
                                    <?php for($i=0; $i<(5-round($executer_rate[$executer->id_user])); $i++): ?>
                                        <span class="star-disabled"></span>
                                    <?php endfor;?>                                    
                                   <b><?= $executer_rate[$executer->id_user]?></b>
                                </div>
                                <span class="new-task__time"><?= Yii::$app->formatter->asRelativeTime($executer->dt_add) ?></span>
                            </div>
                            <div class="feedback-card__content">
                                <p>
                                    <?=$executer->notetext?>
                                </p>
                                <span><?=$executer->bid?> ₽</span>
                            </div>
                            <?php if($user_profile->id === $customer->id and $executer->status !== 'rejected' and $task->current_status === 'new'):?>
                            <div class="feedback-card__actions">
                                <a href="<?=Url::to(['/tasks/responds_action/', 'idtask'=>$task->id, 'idexecuter' => $executer->id_user, 'action' => 'accept'])?>" class="button__small-color request-button button" type="button">Подтвердить</a>
                                <a href="<?=Url::to(['/tasks/responds_action/', 'idtask'=>$task->id, 'idexecuter' => $executer->id_user, 'action' => 'reject'])?>" class="button__small-color refusal-button button" type="button">Отказать</a>
                            </div>
                            <?php endif;?>
                        </div>
                        <?php endif;?>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif;?>
            </section>
            <section class="connect-desk">
                <div class="connect-desk__profile-mini">
                    <div class="profile-mini__wrapper">
                        <h3>Заказчик</h3>
                        <div class="profile-mini__top">
                            <?= Yii::$app->formatter->asImage(isset($customer->avatar) ? '/img/'.$customer->avatar : '/img/upload.png',['width'=>"62", 'height'=>"62", 'alt'=>"Аватар заказчика"]) ?>
                            <div class="profile-mini__name five-stars__rate">
                                <p><?= $customer->fio?></p>
                            </div>
                        </div>
                        <p class="info-customer"><span><?=$customer_tasks_count?> заданий</span><span class="last-">
                            <?= substr(Yii::$app->formatter->asDuration(time()-strtotime($customer->dt_add)),0,strpos(Yii::$app->formatter->asDuration(time()-strtotime($customer->dt_add)),',')) ?>
                             на сайте</span></p>
                        <a href="#" class="link-regular">Смотреть профиль</a>
                    </div>
                </div>
                <div id="chat-container">
<!--                    добавьте сюда атрибут task с указанием в нем id текущего задания-->
                <chat class="connect-desk__chat"></chat>
                </div>
            </section>
        </div>
    </main>

<section class="modal response-form form-modal" id="response-form">
    <h2>Отклик на задание</h2>
    <?php $form = ActiveForm::begin([ 'method' => 'post',
                                'id' => 'execute-form',
                                'action' => Url::to(["/tasks/execute/", 'idtask'=>$task->id]),
                                'validateOnSubmit' => false,
                                'enableAjaxValidation' => true,
                                'enableClientValidation' => true,
                                'options' => ['data-pjax' => 1],
                            ]);?>
    <p>
        <?= $form->field($respond_model, 'bid', ['options' => ['tag' => false]])
                ->textInput(['maxlength' => true
                            , 'class' => 'response-form-payment input input-middle input-money'
                            , 'type' => "text"
                            , 'id' => "response-payment"])
                ->label('Ваша цена',['class' => 'form-modal-description']) ?>
    </p>
    <p>
        <?= $form->field($respond_model, 'notetext', ['options' => ['tag' => false]])
                ->textArea(['id'=>'response-comment', 'placeholder' => "Place your text", 'class' => 'input textarea', 'rows' => 4])
                ->label('Комментарий',['class' => 'form-modal-description'])?>
    </p>
        <?= $form->errorSummary($respond_model); ?>
        <?= Html::submitButton('Отправить', ['class' => "button modal-button",'type' => 'submit','name' => 'submit']) ?>
    <?php ActiveForm::end(); ?>
    <button class="form-modal-close" type="button">Закрыть</button>
</section>

<section class="modal completion-form form-modal" id="complete-form">
    <h2>Завершение задания</h2>
    <p class="form-modal-description">Задание выполнено?</p>
    <?php $form = ActiveForm::begin([ 'action' => Url::to(['/tasks/feedback/', 'idtask'=>$task->id]),
                                   'method' => 'post',
                                   'validateOnSubmit' => false,
                                   'enableAjaxValidation' => false,
                                   'enableClientValidation' => true,
                                ]);?>
    <?= $form->field($feedback_model, 'completion', [ 'options' => ['tag' => false]])
             ->radioList( ['yes' => 'Да','difficult' => 'Возникли проблемы']
                        , ['item' => function($index, $label, $name, $checked, $value) {

                                    $return = '<input type="radio" id="completion-radio--'. $value .'" name = '. $name .' value="' . $value . '" class = "visually-hidden completion-input completion-input--'. $value .'"'. $checked .'>';
                                    $return .= '<label class="completion-label completion-label--'. $value .'" for="completion-radio--'. $value .'">';
                                    $return .=  $label;
                                    $return .= '</label>';

                                    return $return;
                                }
                            ])
            ->label(false)
    ?>
    <p>
    <?= $form->field($feedback_model, 'description', ['options' => ['tag' => false]])
            ->textArea(['id'=>'response-comment', 'placeholder' => "Place your text", 'class' => 'input textarea', 'rows' => 4])
            ->label('Комментарий',['class' => 'form-modal-description'])?>
    </p>
    <p class="form-modal-description">
        Оценка
        <div class="feedback-card__top--name completion-form-star">
            <span class="star-disabled"></span>
            <span class="star-disabled"></span>
            <span class="star-disabled"></span>
            <span class="star-disabled"></span>
            <span class="star-disabled"></span>
        </div>
    </p>
    <?= $form->field($feedback_model, 'rate', ['options' => ['tag' => false]])
             ->textInput(['type' => "hidden", 'id' => "rating"])
             ->label('') ?>
    <?= $form->errorSummary($respond_model); ?>
    <?= Html::submitButton('Отправить', ['class' => "button modal-button",'type' => 'submit','name' => 'submit']) ?>
    <?php ActiveForm::end();?>
    <button class="form-modal-close" type="button">Закрыть</button>
</section>

<section class="modal form-modal refusal-form" id="refuse-form">
    <h2>Отказ от задания</h2>
    <p>
      Вы собираетесь отказаться от выполнения задания.
      Это действие приведёт к снижению вашего рейтинга.
      Вы уверены?
    </p>
    <button class="button__form-modal button" id="close-modal"
            type="button">Отмена
    </button>
    <a href="<?=Url::to(['/tasks/deny/', 'idtask'=>$task->id])?>" class="button__form-modal refusal-button button" type="button">Отказаться
    </a>
    <button class="form-modal-close" type="button">Закрыть</button>
</section>

<div class="overlay"></div>
<script src="js/main.js"></script>
<script src="js/messenger.js"></script>
