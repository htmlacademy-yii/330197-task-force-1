<?php
/* @var $tasks \frontend\controllers\TasksController*/
/* @var $categories \frontend\controllers\TasksController*/

use frontend\functions;
$fun = new Functions();
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
                                    <?= $fun->diff_result($task->dt_add) ?></span>
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
                         <? if(!empty($files)):?>
                        <div class="content-view__attach">
                            <h3 class="content-view__h3">Вложения</h3>
                            <? foreach($files as $file):?>
                                <a href="./user_files/<?=$file['file_path']?>"><?=$file['file_path']?></a>
                            <? endforeach;?>
                        </div>
                        <? endif; ?>
                        <div class="content-view__location">
                            <h3 class="content-view__h3">Расположение</h3>
                            <div class="content-view__location-wrapper">
                                <div class="content-view__map">
                                    <a href="#"><img src="./img/map.jpg" width="361" height="292"
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
                    <div class="content-view__action-buttons">
                            <button class=" button button__big-color response-button open-modal"
                                    type="button" data-for="response-form">Откликнуться</button>
                            <button class="button button__big-color refusal-button open-modal"
                                    type="button" data-for="refuse-form">Отказаться</button>
                      <button class="button button__big-color request-button open-modal"
                              type="button" data-for="complete-form">Завершить</button>
                    </div>
                </div>
                <?php if(count($executers)>0):?>
                <div class="content-view__feedback">
                    <h2>Отклики <span>(<?=count($executers)?>)</span></h2>
                    <div class="content-view__feedback-wrapper">
                        <?php foreach($executers as $executer):?>
                        <div class="content-view__feedback-card">
                            <div class="feedback-card__top">
                                <a href="#"><img src="./img/<?= (isset($executer_info[$executer->id_user]->avatar)) ? $executer_info[$executer->id_user]->avatar :  'upload.png'?>" width="55" height="55"></a>
                                <div class="feedback-card__top--name">
                                    <p><a href="#" class="link-regular"><?=$executer_info[$executer->id_user]->fio?></a></p>
                                    <?php for($i=0; $i<round($executer_rate[$executer->id_user]); $i++): ?>
                                        <span></span>
                                    <?php endfor;?>
                                    <?php for($i=0; $i<(5-round($executer_rate[$executer->id_user])); $i++): ?>
                                        <span class="star-disabled"></span>
                                    <?php endfor;?>                                    
                                   <b><?= $executer_rate[$executer->id_user]?></b>
                                </div>
                                <span class="new-task__time"><?=$fun->diff_result($executer->dt_add)?></span>
                            </div>
                            <div class="feedback-card__content">
                                <p>
                                    <?=$executer->notetext?>
                                </p>
                                <span><?=$executer->bid?> ₽</span>
                            </div>
                            <div class="feedback-card__actions">
                                <a class="button__small-color request-button button"
                                        type="button">Подтвердить</a>
                                <a class="button__small-color refusal-button button"
                                        type="button">Отказать</a>
                            </div>
                        </div>
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
                            <img src="./img/<?= (isset($customer->avatar)) ? $customer->avatar :  'upload.png'?>" width="62" height="62" alt="Аватар заказчика">
                            <div class="profile-mini__name five-stars__rate">
                                <p><?= $customer->fio?></p>
                            </div>
                        </div>
                        <p class="info-customer"><span>12 заданий</span><span class="last-">
                            <?=$fun->diff_result($customer->dt_add,'short');?>
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

