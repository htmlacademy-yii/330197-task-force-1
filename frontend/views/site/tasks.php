<?php
/* @var $tasks \frontend\controllers\TasksController*/
/* @var $categories \frontend\controllers\TasksController*/

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ActiveField;
?>
    <main class="page-main">
        <div class="main-container page-container">
            <section class="new-task">
                <div class="new-task__wrapper">
                    <h1>Новые задания</h1>
                <?php if(isset($tasks)):?>
                    <?php foreach($tasks as $task): ?>
                    <div class="new-task__card">
                        <div class="new-task__title">
                            <a href="#" class="link-regular"><h2><?php echo $task['title'] ?></h2></a>
                            <a  class="new-task__type link-regular" href="#"><p><?php echo $task['category'] ?></p></a>
                        </div>
                        <div class="new-task__icon new-task__icon--<?php echo $task['icon']?>"></div>
                        <p class="new-task_description">
                            <?php echo $task['description'] ?>
                        </p>
                        <b class="new-task__price new-task__price--<?php echo $task['icon']?>"><?php echo $task['budget'] ?><b> ₽</b></b>
                        <p class="new-task__place"><?php echo $task['address'] ?></p>
                        <span class="new-task__time"><?php echo $task['date_diff'] ?></span>
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
                    <?php $form = ActiveForm::begin([
                            'action' => ['index'],
                            'method' => "post",
                            'options' => ['data-pjax' => 1, 'class' => 'search-task__form'],
                            'enableAjaxValidation' => false, 
                        ]); ?> 
                        <fieldset class="search-task__categories">
                            <legend>Категории</legend>
                            <?= $form->field($model, 'category',['template' => '{input}'])
                                ->checkboxList($categories,
                                    [
                                        'item' => function ($index, $label, $name, $checked, $value) {
                                                return Html::checkbox($name, $checked, ['value' => $value,'id' => 'cat-'.$value,'label' => $label]);
                                        },
                                    ], false
                                )
                                ->label('',['class' => 'visually-hidden checkbox__input'])?> 
                        </fieldset>
                        <fieldset class="search-task__categories">
                            <legend>Дополнительно</legend>
                            <?= $form->field($model, 'no_executers')->checkbox(['fieldOptions' => ['class' => 'visually-hidden checkbox__input']])?>
                            <?= $form->field($model, 'no_address')->checkbox(['fieldOptions' => ['class' => 'visually-hidden checkbox__input']])?>
                        </fieldset>
                        
                        <?= $form->field($model, 'period')->dropDownList($period, ['class' => 'multiple-select input'])->label('Период',['class' => 'search-task__name'])?>

                        <?= $form->field($model, 'search')->textInput(['class' => "input-middle input"])->label('Поиск по названию',['class' => 'search-task__name'])?>

                        <div class="form-group">
                        <?= Html::submitButton('Искать', ['class' => "button",'type' => 'submit','name' => 'submit']) ?>
                        </div>
                    <?php ActiveForm::end(); ?> 

                </div>
            </section>
        </div>
    </main>

