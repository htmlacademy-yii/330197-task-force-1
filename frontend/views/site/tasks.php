<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
// use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\widgets\ActiveForm;
use yii\widgets\ActiveField;
?>
    <main class="page-main">
        <div class="main-container page-container">
            <section class="new-task">
                <div class="new-task__wrapper">
                    <h1>Новые задания</h1>
                <?php if(isset($data)):?>
                    <?php foreach($data as $value): ?>
                    <div class="new-task__card">
                        <div class="new-task__title">
                            <a href="#" class="link-regular"><h2><?php echo $value['title'] ?></h2></a>
                            <a  class="new-task__type link-regular" href="#"><p><?php echo $value['category'] ?></p></a>
                        </div>
                        <div class="new-task__icon new-task__icon--<?php echo $value['icon']?>"></div>
                        <p class="new-task_description">
                            <?php echo $value['description'] ?>
                        </p>
                        <b class="new-task__price new-task__price--<?php echo $value['icon']?>"><?php echo $value['budget'] ?><b> ₽</b></b>
                        <p class="new-task__place"><?php echo $value['address'] ?></p>
                        <span class="new-task__time"><?php echo $value['date_diff'] ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="new-task__pagination">
                    <ul class="new-task__pagination-list">
                        <li class="pagination__item"><a href="#"></a></li>
                        <li class="pagination__item pagination__item--current">
                            <a>1</a></li>
                        <li class="pagination__item"><a href="#">2</a></li>
                        <li class="pagination__item"><a href="#">3</a></li>
                        <li class="pagination__item"><a href="#"></a></li>
                    </ul>
                </div>
                <?php else:?>
                    <br />
                    <p class="new-task_description">По вашему запросу ничего не найдено.</p>
                
                <?php endif;?>
            </section>
            <section  class="search-task">
                <div class="search-task__wrapper">
                    <form class="search-task__form" name="test" method="post">
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
                        <label class="search-task__name" for="8">Период</label>
                            <select class="multiple-select input" id="8"size="1" name="period">
                            <option value="all_time">За всё время</option>
                        <?php foreach($period as $key => $value):?>
                            <option value="<?php echo $key?>"><?php echo $value?></option>
                        <?php endforeach;?>
                        </select>
                        <label class="search-task__name" for="9">Поиск по названию</label>
                            <input class="input-middle input" id="9" type="search" name="find" placeholder="">
                        <button class="button" type="submit">Искать</button>
                    </form>
                </div>
            </section>
        </div>
    </main>
    