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

use frontend\functions;
$fun = new Functions();
?>
    <main class="page-main">
        <div class="main-container page-container">
            <section class="content-view">
                <div class="user__card-wrapper">
                    <div class="user__card">
                        <img src="./img/<?= (isset($user->avatar)) ? $user->avatar : 'upload.png'?>" width="120" height="120" alt="Аватар пользователя">
                         <div class="content-view__headline">
                            <h1><?=$user->fio?></h1>
                             <p><?=$user_country->country?>, <?=$user_city->city?>, <?=$fun->diff_result($user->birthday,'short');?></p>
                            <div class="profile-mini__name five-stars__rate">                                
                                <? for($i=0; $i<round($user_rate); $i++): ?>
                                <span></span>
                                <? endfor;?>
                                <? for($i=0; $i<(5-round($user_rate)); $i++): ?>
                                    <span class="star-disabled"></span>
                                <? endfor;?>
                                <b><?= $user_rate?></b>
                            </div>
                            <b class="done-task">Выполнил <?=$user_tasks?> заказов</b><b class="done-review">Получил <?=count($user_feedbacks)?> отзывов</b>
                         </div>
                        <div class="content-view__headline user__card-bookmark user__card-bookmark--current">
                            <span>Был на сайте <?=$fun->diff_result($user->last_update);?></span>
                             <a href="#"><b></b></a>
                        </div>
                    </div>
                    <div class="content-view__description">
                        <p><?=$user->about?></p>
                    </div>
                    <div class="user__card-general-information">
                        <div class="user__card-info">
                            <h3 class="content-view__h3">Специализации</h3>
                            <div class="link-specialization">
                            <?foreach($user_categories as $category):?>
                             <a href="#" class="link-regular"><?=$category?></a>                             
                             <?endforeach;?>
                            </div>
                            <h3 class="content-view__h3">Контакты</h3>
                            <div class="user__card-link">
                                <a class="user__card-link--tel link-regular" href="#">
                                    <?$ph = str_split($user->phone);
                                        if($ph[0] !== 8 or count($ph)<11) {
                                            array_unshift($ph,8);
                                        } 
                                        echo "$ph[0] ($ph[1]$ph[2]$ph[3]) $ph[4]$ph[5]$ph[6] $ph[7]$ph[8] $ph[9]$ph[10]";
                                    ?></a>
                                <a class="user__card-link--email link-regular" href="#"><?=$user->email?></a>
                                <a class="user__card-link--skype link-regular" href="#"><?=$user->skype?></a>
                            </div>
                         </div>
                         <? if(!empty($user_portfolio)): ?>
                        <div class="user__card-photo">                            
                            <h3 class="content-view__h3">Фото работ</h3>
                            <? foreach($user_portfolio as $photo): ?>
                            <a href="#"><img src="./user_files/<?=$photo?>" width="85" height="86" alt="Фото работы"></a>
                            <? endforeach; ?>
                         </div>
                         <? endif ?>
                    </div>
                </div>
                <?if(!empty($user_feedbacks)):?>
                <div class="content-view__feedback">
                    <h2>Отзывы<span>(<?=count($user_feedbacks)?>)</span></h2>
                    <div class="content-view__feedback-wrapper reviews-wrapper">
                        <?foreach($user_feedbacks as $feedback):?>
                        <div class="feedback-card__reviews">
                            <p class="link-task link">Задание <a href="/tasks/view/<?=$feedback['task_id']?>" class="link-regular">«<?=$feedback['task_title']?>»</a></p>
                            <div class="card__review">
                                <a href="#"><img src="./img/<?= (isset($feedback['owner_avatar'])) ? $feedback['owner_avatar'] : 'upload.png'?>" width="55" height="54"></a>
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
                        <?endforeach;?>
                    </div>
                </div>
                <?endif;?>
            </section>
            <section class="connect-desk">
                <div class="connect-desk__chat">

                </div>
            </section>
        </div>
    </main>
