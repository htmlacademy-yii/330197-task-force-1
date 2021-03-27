<?php
/* @var $form_model \frontend\controllers\SignupController*/

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ActiveField;
?>
    <main class="page-main">
        <div class="main-container page-container">
            <section class="registration__user">
                <h1>Регистрация аккаунта</h1>
                <div class="registration-wrapper">
                    <?php $error_class = "";
                        if(isset($error)){
                            $error_class = "has-error";
                        }
                        $form = ActiveForm::begin([
                            'method' => "post",
                            'options' => ['data-pjax' => 1, 'class' => 'registration__user-form form-create'],
                            'validateOnSubmit' => false,
                            'enableAjaxValidation' => false,
                            'enableClientValidation' => true,
                            'fieldConfig' => [
                                'template' => " <div class=\"field-container field-container--registration $error_class \">{label}\n{input}\n<span class='registration__text-error'>{hint}</span>\n{error}\n</div>",
                                'inputOptions' => [ 'class' => "input textarea", 'rows' => '1'],
                            ],
                        ]); ?>
                        <?= $form->field($form_model, 'email', ['options' => ['tag' => false]])
                                    ->textArea(['id'=>'16', 'placeholder' => "kumarm@mail.ru", 'autofocus' => true])
                                    ->hint('Введите валидный адрес электронной почты')
                                    ->label('Электронная почта')?>

                        <?= $form->field($form_model, 'fio', ['options' => ['tag' => false]])
                                    ->textArea(['id'=>'17', 'placeholder' => "Мамедов Кумар"])
                                    ->hint('Введите ваше имя и фамилию')
                                    ->label('Ваше имя')?>

                        <?= $form->field($form_model, 'city_id', ['options' => ['tag' => false]])
                                    ->dropDownList($cities, ['class' => 'multiple-select input town-select registration-town', 'size' => '1', 'id' => '18'])
                                    ->hint('Укажите город, чтобы находить подходящие задачи')
                                    ->label('Город проживания')?>

                        <?= $form->field($form_model, 'role', ['options' => ['tag' => false]])
                                    ->dropDownList($role, ['class' => 'multiple-select input town-select registration-town', 'size' => '1', 'id' => '20'])
                                    ->hint('Выберите роль, чтобы создавать новые задачи или получать заказы для выполнения')
                                    ->label('Выберите роль')?>

                        <?= $form->field($form_model, 'password', ['options' => ['tag' => false]])
                                    ->passwordInput(['id'=>'19'])
                                    ->hint('Длина пароля от 8 символов')
                                    ->label('Пароль')?>

                        <?= Html::submitButton('Cоздать аккаунт', ['class' => "button button__registration",'type' => 'submit','name' => 'submit']) ?>
                    <?php ActiveForm::end(); ?>
                </div>
            </section>
        </div>
    </main>
