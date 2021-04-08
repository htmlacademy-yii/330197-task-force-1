<?
/* @var $executers \frontend\controllers\UsersController*/
/* @var $categories \frontend\controllers\UsersController*/
/* @var $addition \frontend\controllers\UsersController*/

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ActiveField;
use yii\helpers\Url;
$this->title = 'Исполнители';
?>
    <main class="page-main">
        <div class="main-container page-container">
            <section class="user__search">
                <?php if(isset($users) and !empty($users[0]['id'])): ?>
                <div class="user__search-link">
                    <p>Сортировать по:</p>
                    <ul class="user__search-list">
                        <li class="user__search-item 
                        <?= (!isset($sortField) or $sortField === 'rate') ? 'user__search-item--current' : '' ?>">
                            <a href="<?=Url::to(['/users/', 's'=>'rate'])?>" class="link-regular">Рейтингу</a>
                        </li>
                        <li class="user__search-item 
                        <?= (isset($sortField) and $sortField === 'orders') ? 'user__search-item--current' : '' ?>">
                            <a href="<?=Url::to(['/users/', 's'=>'orders'])?>" class="link-regular">Числу заказов</a>
                        </li>
                        <li class="user__search-item 
                        <?= (isset($sortField) and $sortField === 'favor') ? 'user__search-item--current' : '' ?>">
                            <a href="<?=Url::to(['/users/', 's'=>'favor'])?>" class="link-regular">Популярности</a>
                        </li>
                    </ul>
                </div>
                <?php foreach($users as $user): ?>
                <div class="content-view__feedback-card user__search-wrapper">
                    <div class="feedback-card__top">
                        <div class="user__search-icon">
                            <a href="<?=Url::to(['/users/view/', 'id'=>$user->id])?>"><?= Yii::$app->formatter->asImage(isset($user->avatar) ? '/img/'.$user->avatar : '/img/upload.png',['width'=>"65", 'height'=>"65", 'alt'=>"Аватар"]) ?></a>
                            <span><?= $users_tasks[$user->id]?> заданий</span>
                            <span><?= $users_rate['feedbacks'][$user->id]?> отзывов</span>
                        </div>
                        <div class="feedback-card__top--name user__search-card">
                            <p class="link-name"><a href="<?=Url::to(['/users/view/', 'id'=>$user->id])?>" class="link-regular"><? echo $user->fio?></a></p>
                            <?php for($i=0; $i<round($users_rate['rate'][$user->id]); $i++): ?>
                                <span></span>
                            <?php endfor;?>
                            <?php for($i=0; $i<(5-round($users_rate['rate'][$user->id])); $i++): ?>
                                <span class="star-disabled"></span>
                            <?php endfor;?>
                            <b><?= $users_rate['rate'][$user->id]?></b>
                            <p class="user__search-content">
                                <?= $user->about; ?>
                            </p>
                        </div>
                        <span class="new-task__time">Был на сайте <?= Yii::$app->formatter->asRelativeTime($user->last_update) ?></span>
                    </div>
                    <div class="link-specialization user__search-link--bottom">
                        <?php foreach($users_categories[$user->id] as $category): ?>
                        <a href="#" class="link-regular"><?= $category ?></a>
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
                    <?php $form = ActiveForm::begin([
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
                    <?php ActiveForm::end(); ?>
                </div>
            </section>
        </div>
    </main>
