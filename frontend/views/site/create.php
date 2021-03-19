<?php
/* @var $form_model \frontend\controllers\CreateController*/

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ActiveField;
?>
  <main class="page-main">
    <div class="main-container page-container">
      <section class="create__task">
        <h1>Публикация нового задания</h1>
        <div class="create__task-main">
          <?php 
            $form = ActiveForm::begin([
                'method' => "post",
                'options' => ['data-pjax' => 1, 'class' => 'create__task-form form-create'],
                'validateOnSubmit' => false,
                'enableAjaxValidation' => false,
                'enableClientValidation' => true,
                'fieldConfig' => [
                    'template' => " <div class='field-container'>{label}\n{input}\n<span>{hint}</span>\n</div>",
                    // 'inputOptions' => [ 'class' => "input textarea", 'rows' => '1'],
                    'labelOptions' => [ 'class' => ''],
                    'hintOptions' => [ 'class' => ''],
                  ],
            ]); ?>
            <?= $form->field($form_model, 'title', ['options' => ['tag' => false]
                                                  , 'inputOptions' => [ 'class' => "input textarea"
                                                                      , 'rows' => '1'
                                                                      , 'placeholder' => "Повесить полку"
                                                                      , 'autofocus' => true]])
                        ->input(['id'=>'10'])
                        ->hint('Кратко опишите суть работы')
                        ->label('Мне нужно')?>

            <?= $form->field($form_model, 'description', ['options' => ['tag' => false]
                                                        , 'inputOptions' => [ 'class' => "input textarea"
                                                                            , 'rows' => '7'
                                                                            , 'placeholder' => "Place your text"]])
                        ->textArea(['id'=>'11'])
                        ->hint('Укажите все пожелания и детали, чтобы исполнителям было проще соориентироваться')
                        ->label('Подробности задания')?>

            <?= $form->field($form_model, 'idcategory', ['options' => ['tag' => false]])
                        ->dropDownList($categories, ['class' => 'multiple-select input multiple-select-big', 'size' => '1', 'id' => '12'])
                        ->hint('Выберите категорию')
                        ->label('Категория')?>

            <?= $form->field($form_model, 'file', [ 'options' => ['tag' => false]
                                                  , 'template' => "{label}\n<span>{hint}</span>\n<div class='create__file'>{input}\n<span>Добавить новый файл</span>\n</div>"
                                                  // , 'inputOptions' => [ 'style' => "display:none"]
                                                  // , 'inputOptions' => [ 'name'=>Yii::$app->request->csrfParam
                                                  //                     , 'value'=>Yii::$app->request->csrfToken
                                                  //                     , 'style' => "display:none"]
                                                  ])
                        // ->hiddenInput()
                        // ->hiddenInput(['value'=> $src->state])                       
                        ->fileInput()
                        ->hint('Загрузите файлы, которые помогут исполнителю лучше выполнить или оценить работу')
                        ->label('Файлы')?>

            <?= $form->field($form_model, 'idcity', ['options' => ['tag' => false]                                                    
                                                    , 'inputOptions' => [ 'class' => "input-navigation input-middle input"
                                                                        , 'placeholder' => "Санкт-Петербург, Калининский район"
                                                                        , 'type' => 'search'
                                                                        , 'id'=>'13']])
                        ->input(['id'=>'13'])
                        ->hint('Укажите адрес исполнения, если задание требует присутствия')
                        ->label('Локация')?>

            <div class="create__price-time">
            <?= $form->field($form_model, 'budget', ['options' => ['tag' => false]
                                                    , 'template' => " <div class='field-container create__price-time--wrapper'>{label}\n{input}\n<span>{hint}</span>\n</div>"
                                                    , 'inputOptions' => [ 'class' => 'input textarea input-money'
                                                                        , 'placeholder' => "1000"
                                                                        , 'type' => 'text'
                                                                        , 'id'=>'14']
                                                    ])
                        ->input(['id'=>'14'])
                        ->hint('Не заполняйте для оценки исполнителем')
                        ->label('Бюджет')?>

            <?= $form->field($form_model, 'deadline', ['options' => ['tag' => false]
                                                    , 'template' => " <div class='field-container create__price-time--wrapper'>{label}\n{input}\n<span>{hint}</span>\n</div>"
                                                    , 'inputOptions' => [ 'class' => 'input-middle input input-date'
                                                                        , 'placeholder' => "10.11, 15:00"
                                                                        , 'type' => 'text'
                                                                        , 'id'=>'15']
                                                    ])
                        ->input(['id'=>'15'])
                        ->hint('Укажите крайний срок исполнения')
                        ->label('Сроки исполнения')?>
            </div>
            
            <?= Html::submitButton('Опубликовать', ['class' => "button",'type' => 'submit','name' => 'submit']) ?>
          <?php ActiveForm::end(); ?>
          <div class="create__warnings">
            <div class="warning-item warning-item--advice">
              <h2>Правила хорошего описания</h2>
              <h3>Подробности</h3>
              <p>Друзья, не используйте случайный<br>
                контент – ни наш, ни чей-либо еще. Заполняйте свои
                макеты, вайрфреймы, мокапы и прототипы реальным
                содержимым.</p>
              <h3>Файлы</h3>
              <p>Если загружаете фотографии объекта, то убедитесь,
                что всё в фокусе, а фото показывает объект со всех
                ракурсов.</p>
            </div>
            <?if(isset($form_model->errors)):?>
            <div class="warning-item warning-item--error">
              <h2>Ошибки заполнения формы</h2>
              <?foreach($form_model->errors as $field=>$array_errors):?>
                <?foreach($array_errors as $error):?>
                <p><?=$error?></p>
                <?endforeach;?>
              <?endforeach;?>
            </div>
          <? endif;?>
          </div>      
        </div>          
      </section>
    </div>
  </main>
<!-- <script src="js/dropzone.js"></script>
<script>
  var dropzone = new Dropzone("div.create__file", {url: "/create/upload/", paramName: "file"});
</script> -->
