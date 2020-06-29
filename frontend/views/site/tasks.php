<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
// use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\widgets\ActiveForm;
use yii\widgets\ActiveField;

require_once '../../vendor/autoload.php';

$this->title = 'Задачи';
$this->params['breadcrumbs'][] = $this->title;
?>
     <h1><?= Html::encode($this->title) ?></h1>  
    <main class="page-main">
        <div class="main-container page-container">
            <section class="new-task">
                <div class="new-task__wrapper">
                    <h1>Новые задания</h1>
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
            </section>
            <section  class="search-task">
                <div class="search-task__wrapper">
                    <?php $form = ActiveForm::begin([
                            'action' => ['index'],
                            'method' => "post",
                            'options' => [
                                'data-pjax' => 1,
                                'class' => 'search-task__form',
                            ],
                        ]); ?> 

                        <fieldset class="search-task__categories">
                            <legend>Категории</legend>
                            <?= $form->field($model, 'category',[
                                'template' => '{input}',
                                // 'template' => '{input}{label}'
                                
                            ])
                                ->checkboxList($categories,
                                    [
                                        'item' => function ($index, $label, $name, $checked, $value) {
                                                return Html::checkbox($name, $checked, [
                                                    'value' => $value,
                                                    'id' => 'cat-'.$value,
                                                    'label' => $label,
                                                    // 'label' => '<label for="cat-' . $value . '">' . $label . '</label>',
                                                ]);
                                        },
                                    ], false
                                )
                                ->label('',['class' => 'visually-hidden checkbox__input'])?> 
                        </fieldset>
                        <fieldset class="search-task__categories">
                            <legend>Дополнительно</legend>
                            <?= $form->field($model, 'no_executers')
                                    ->checkbox(['fieldOptions' => ['class' => 'visually-hidden checkbox__input']])
                                    ?>
                            <?= $form->field($model, 'no_address')
                                    ->checkbox(
                                    ['class' => 'visually-hidden checkbox__input'])?>
                        </fieldset>
                        
                        <?= $form->field($model, 'period')
                                ->dropDownList($period, ['class' => 'multiple-select input'])
                                ->label('Период',['class' => 'search-task__name'])?>

                        <?= $form->field($model, 'search')
                                ->textInput(['class' => "input-middle input"])
                                ->label('Поиск по названию',['class' => 'search-task__name'])?>
                        <div class="form-group">
                        <?= Html::submitButton('Искать', ['class' => "button",
                                                          'type' => 'submit', 
                                                          'name' => 'submit']) ?>
                        </div>
                    <?php ActiveForm::end(); ?>
                </div>
                <div class="search-task__wrapper">
                    <form class="search-task__form" name="test" method="post" action="#">
                        <fieldset class="search-task__categories">
                            <legend>Категории</legend>
                            <input class="visually-hidden checkbox__input" id="1" type="checkbox" name="" value="" checked>
                            <label for="1">Курьерские услуги </label>
                            <input class="visually-hidden checkbox__input" id="2" type="checkbox" name="" value="" checked>
                            <label  for="2">Грузоперевозки </label>
                            <input class="visually-hidden checkbox__input" id="3" type="checkbox" name="" value="">
                            <label  for="3">Переводы </label>
                            <input class="visually-hidden checkbox__input" id="4" type="checkbox" name="" value="">
                            <label  for="4">Строительство и ремонт </label>
                            <input class="visually-hidden checkbox__input" id="5" type="checkbox" name="" value="">
                            <label  for="5">Выгул животных </label>
                        </fieldset>
                        <fieldset class="search-task__categories">
                            <legend>Дополнительно</legend>
                            <input class="visually-hidden checkbox__input" id="6" type="checkbox" name="" value="">
                            <label for="6">Без откликов</label>
                           <input class="visually-hidden checkbox__input" id="7" type="checkbox" name="" value="" checked>
                            <label for="7">Удаленная работа </label>
                        </fieldset>
                       <label class="search-task__name" for="8">Период</label>
                           <select class="multiple-select input" id="8"size="1" name="time[]">
                            <option value="day">За день</option>
                            <option selected value="week">За неделю</option>
                            <option value="month">За месяц</option>
                        </select>
                        <label class="search-task__name" for="9">Поиск по названию</label>
                            <input class="input-middle input" id="9" type="search" name="q" placeholder="">
                        <button class="button" type="submit">Искать</button>
                    </form>
                </div>
            </section>
        </div>
    </main>
    