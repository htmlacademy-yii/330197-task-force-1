<?php
/* @var $executers \frontend\controllers\UsersController*/
/* @var $categories \frontend\controllers\UsersController*/
/* @var $addition \frontend\controllers\UsersController*/

use yii\helpers\Html;

$this->title = 'Исполнители';
$this->params['breadcrumbs'][] = $this->title;
?>
    <main class="page-main">
        <div class="main-container page-container">
            <section class="user__search">
                <div class="user__search-link">
                    <p>Сортировать по:</p>
                    <ul class="user__search-list">
                        <li class="user__search-item user__search-item--current">
                            <a href="#" class="link-regular">Рейтингу</a>
                        </li>
                        <li class="user__search-item">
                            <a href="#" class="link-regular">Числу заказов</a>
                        </li>
                        <li class="user__search-item">
                            <a href="#" class="link-regular">Популярности</a>
                        </li>
                    </ul>
                </div>
            <?php if(isset($executers)):?>
                <?php foreach($executers as $executer): ?>
                <div class="content-view__feedback-card user__search-wrapper">
                    <div class="feedback-card__top">
                        <div class="user__search-icon">
                            <a href="#"><img src="./img/<?php if(isset($executer['avatar'])) { echo $executer['avatar'];} else { echo 'upload.png';}  ?>" width="65" height="65"></a>
                            <span><?php echo $executer['qtask']?> заданий</span>
                            <span><?php echo $executer['qrate']?> отзывов</span>
                        </div>
                        <div class="feedback-card__top--name user__search-card">
                            <p class="link-name"><a href="#" class="link-regular"><?php echo $executer['fio']?></a></p>
                            <?php for($i=0; $i<round($executer['rate']); $i++): ?>
                                <span></span>
                            <?php endfor;?>
                            <?php for($i=0; $i<(5-round($executer['rate'])); $i++): ?>
                                <span class="star-disabled"></span>
                            <?php endfor;?>
                            <b><?php echo $executer['rate']?></b>
                            <p class="user__search-content">
                                <?php echo $executer['about']?>
                            </p>
                        </div>
                        <span class="new-task__time">Был на сайте <?php echo $executer['last_update']?></span>
                    </div>
                    <div class="link-specialization user__search-link--bottom">
                        <?php foreach($executer['categories'] as $category): ?>
                            <a href="#" class="link-regular"><?php echo $category ?></a>
                        <?php endforeach;?>
                    </div>
                </div>
                <?php endforeach;?>
            <?php else:?>
                <p></p>
                <p class="new-task_description">По вашему запросу ничего не найдено.</p>
            <?php endif;?>
            </section>
            <section  class="search-task">
                <div class="search-task__wrapper">
                    <form class="search-task__form" name="users" method="post">
                        <fieldset class="search-task__categories">
                            <legend>Категории</legend>
                        <?php foreach($categories as $id => $category):?>
                            <input class="visually-hidden checkbox__input" id="cat-<?php echo $id?>" type="checkbox" name="categories[]" value="<?php echo $id?>">
                            <label for="cat-<?php echo $id?>"><?php echo $category ?></label>
                        <?php endforeach;?>
                        </fieldset>
                        <fieldset class="search-task__categories">
                            <legend>Дополнительно</legend>
                        <?php foreach($addition as $key => $value):?>
                            <input class="visually-hidden checkbox__input" id="<?php echo $key?>" type="checkbox" name="<?php echo $key?>" value="<?php echo $key?>">
                            <label for="<?php echo $key?>"><?php echo $value?></label>
                        <?php endforeach;?>
                        </fieldset>
                        <label class="search-task__name" for="110">Поиск по имени</label>
                        <input class="input-middle input" id="110" type="search" name="find" placeholder="">
                        <button class="button" type="submit">Искать</button>
                    </form>
                </div>
            </section>
        </div>
    </main>
