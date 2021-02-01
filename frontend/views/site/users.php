<?
/* @var $executers \frontend\controllers\UsersController*/
/* @var $categories \frontend\controllers\UsersController*/
/* @var $addition \frontend\controllers\UsersController*/

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ActiveField;
use frontend\functions;
$fun = new Functions();
$this->title = 'Исполнители';
?>
    <main class="page-main">
        <div class="main-container page-container">
            <section class="user__search">
                <? if(isset($users) and !empty($users[0]['id'])): ?>
                <div class="user__search-link">
                    <p>Сортировать по:</p>
                    <ul class="user__search-list">
                        <li class="user__search-item <? if(!isset($sortField) or $sortField === 'rate') {echo 'user__search-item--current';} ?>">
                            <a href="/users?s=rate" class="link-regular">Рейтингу</a>
                        </li>
                        <li class="user__search-item <? if(isset($sortField) and $sortField === 'orders') {echo 'user__search-item--current';} ?>">
                            <a href="/users?s=orders" class="link-regular">Числу заказов</a>
                        </li>
                        <li class="user__search-item <? if(isset($sortField) and $sortField === 'favor') {echo 'user__search-item--current';} ?>">
                            <a href="/users?s=favor" class="link-regular">Популярности</a>
                        </li>
                    </ul>
                </div>
                <? foreach($users as $user): ?>
                <div class="content-view__feedback-card user__search-wrapper">
                    <div class="feedback-card__top">
                        <div class="user__search-icon">
                            <a href="/users/view/<?=$user->id?>"><img src="./img/<?=isset($user->avatar) ? $user->avatar : 'upload.png'?>" width="65" height="65"></a>
                            <span><? echo $users_tasks[$user->id]?> заданий</span>
                            <span><? echo $users_rate['feedbacks'][$user->id]?> отзывов</span>
                        </div>
                        <div class="feedback-card__top--name user__search-card">
                            <p class="link-name"><a href="/users/view/<?=$user->id?>" class="link-regular"><? echo $user->fio?></a></p>
                            <? for($i=0; $i<round($users_rate['rate'][$user->id]); $i++): ?>
                                <span></span>
                            <? endfor;?>
                            <? for($i=0; $i<(5-round($users_rate['rate'][$user->id])); $i++): ?>
                                <span class="star-disabled"></span>
                            <? endfor;?>
                            <b><?= $users_rate['rate'][$user->id]?></b>
                            <p class="user__search-content">
                                <?= $user->about; ?>
                            </p>
                        </div>
                        <span class="new-task__time">Был на сайте <? echo $fun->diff_result($user->last_update) ?></span>
                    </div>
                    <div class="link-specialization user__search-link--bottom">
                        <? foreach($users_categories[$user->id] as $category): ?>
                        <a href="#" class="link-regular"><? echo $category ?></a>
                        <? endforeach;?>
                    </div>
                </div>
            <? endforeach;?>
            <? else:?>
                <p></p>
                <p class="new-task_description">По вашему запросу ничего не найдено.</p>
            <? endif;?>
            </section>
            <section  class="search-task">
                <div class="search-task__wrapper">
                    <? $form = ActiveForm::begin([
                            'method' => "post",
                            'options' => ['data-pjax' => 1, 'class' => 'search-task__form'],
                            'validateOnSubmit' => false,
                        ]); ?>
                        <fieldset class="search-task__categories">
                            <legend>Категории</legend>
                            <?= $form->field($user_form, 'category')->checkboxList($categories,
                                ['item' => function ($index, $label, $name, $checked, $value) {
                                    return Html::checkbox($name, $checked, ['value' => $value,'id' => 'category-'.$value,'label' => $label]); 
                                    },
                                ])->label('',['class' => 'visually-hidden checkbox__input'])?>
                        </fieldset>
                        <fieldset class="search-task__categories">
                            <legend>Дополнительно</legend>
                            <?= $form->field($user_form, 'free')->checkbox(['label' => 'Сейчас свободен'])->label('Без откликов',['class' => 'visually-hidden checkbox__input'])?>
                            <?= $form->field($user_form, 'online')->checkbox(['label' => 'Сейчас онлайн'])?>
                            <?= $form->field($user_form, 'feedback')->checkbox(['label' => 'Есть отзывы'])?>
                            <?= $form->field($user_form, 'favorite')->checkbox(['label' => 'В избранном'])?>
                        </fieldset>
                        <?= $form->field($user_form, 'search')->textInput(['class' => "input-middle input"])->label('Поиск по имени',['class' => 'search-task__name'])?>

                        <div class="form-group">
                        <?= Html::submitButton('Искать', ['class' => "button",'type' => 'submit','name' => 'submit']) ?>
                        </div>
                    <? ActiveForm::end(); ?>
                </div>
            </section>
        </div>
    </main>
