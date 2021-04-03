<?php
/* @var $user \frontend\controllers\UsersController\actionView */
/* @var $categories \frontend\controllers\UsersController\actionView */
/* @var $user_rate \frontend\controllers\UsersController\actionView */
/* @var $user_tasks \frontend\controllers\UsersController\actionView */
/* @var $user_city \frontend\controllers\UsersController\actionView */
/* @var $user_country \frontend\controllers\UsersController\actionView */
/* @var $user_categories \frontend\controllers\UsersController\actionView */
/* @var $user_portfolio \frontend\controllers\UsersController\actionView */
/* @var $user_feedbacks \frontend\controllers\UsersController\actionView */

use yii\helpers\Url;
use frontend\src\CustomFormatter;
?>
    <main class="page-main">
        <div class="main-container page-container">
            <section class="content-view">
                <div class="user__card-wrapper">
                    <div class="user__card">
                        <img src="/img/<?= (isset($user->avatar)) ? $user->avatar : 'upload.png'?>" width="120" height="120" alt="Аватар пользователя">
                         <div class="content-view__headline">
                            <h1><?=$user->fio?></h1>
                            <p> <?=$user_country->country?>, <?=$user_city->city?>,
                                <?php if(isset($user->birthday)): ?>
                                    <?= substr(Yii::$app->formatter->asDuration(time()-strtotime($user->birthday)), 0, strpos(Yii::$app->formatter->asDuration(time()-strtotime($user->birthday)),','))?>
                                <?php endif;?>
                            </p>
                            <div class="profile-mini__name five-stars__rate">                                
                                <?php for($i=0; $i<round($user_rate); $i++): ?>
                                <span></span>
                                <?php endfor;?>
                                <?php for($i=0; $i<(5-round($user_rate)); $i++): ?>
                                    <span class="star-disabled"></span>
                                <?php endfor;?>
                                <b><?= $user_rate?></b>
                            </div>
                            <b class="done-task">Выполнил <?=$user_tasks?> заказов</b>
                            <b class="done-review">Получил <?=count($user_feedbacks)?> отзывов</b>
                         </div>
                        <div class="content-view__headline user__card-bookmark user__card-bookmark--current">
                            <span>Был на сайте <?= Yii::$app->formatter->asRelativeTime($user->last_update);?></span>
                             <a href="#"><b></b></a>
                        </div>
                    </div>
                    <div class="content-view__description">
                        <p><?=$user->about?></p>
                    </div>
                    <div class="user__card-general-information">
                        <div class="user__card-info">
                        <?php if($user_categories):?>
                            <h3 class="content-view__h3">Специализации</h3>
                            <div class="link-specialization">
                            <?php foreach($user_categories as $category):?>
                             <a href="#" class="link-regular"><?=$category?></a>                             
                             <?php endforeach;?>
                            </div>
                        <?php  endif;?>
                            <h3 class="content-view__h3">Контакты</h3>
                            <div class="user__card-link">
                                <?= CustomFormatter::asPhone($user->phone,['class' => "user__card-link--tel link-regular"]) ?>
                                <?= Yii::$app->formatter->asEmail($user->email, ['class' => "user__card-link--email link-regular"])?>
                                <?= CustomFormatter::asSkype($user->skype,['class' => "user__card-link--skype link-regular"]) ?>
                            </div>
                         </div>
                         <?php  if(!empty($user_portfolio)): ?>
                        <div class="user__card-photo">                            
                            <h3 class="content-view__h3">Фото работ</h3>
                            <?php  foreach($user_portfolio as $p): ?>
                            <a href="#"><img src="/user_files/<?=$p->photo?>" width="85" height="86" alt="Фото работы"></a>
                            <?php  endforeach; ?>
                         </div>
                         <?php  endif ?>
                    </div>
                </div>
                <?php if(!empty($user_feedbacks)):?>
                <div class="content-view__feedback">
                    <h2>Отзывы<span>(<?=count($user_feedbacks)?>)</span></h2>
                    <div class="content-view__feedback-wrapper reviews-wrapper">
                        <?php foreach($user_feedbacks as $feedback):?>
                        <div class="feedback-card__reviews">
                            <p class="link-task link">Задание <a href="<?=Url::to(['/tasks/view/', 'id'=>$feedback['task_id']])?>" class="link-regular">«<?=$feedback['task_title']?>»</a></p>
                            <div class="card__review">
                                <a href="#"><img src="/img/<?= (isset($feedback['owner_avatar'])) ? $feedback['owner_avatar'] : 'upload.png'?>" width="55" height="54"></a>
                                <div class="feedback-card__reviews-content">
                                    <p class="link-name link"><a href="#" class="link-regular"><?=$feedback['owner_fio']?></a></p>
                                    <p class="review-text">
                                        <?=$feedback['description']?>
                                    </p>
                                </div>
                                <div class="card__review-rate">
                                    <p class="<?=$feedback['rate_text']?>-rate big-rate"><?=$feedback['rate']?><span></span></p>
                                </div>
                            </div>
                        </div>
                        <?php endforeach;?>
                    </div>
                </div>
                <?php endif;?>
            </section>
            <section class="connect-desk">
                <div class="connect-desk__chat">

                </div>
            </section>
        </div>
    </main>
