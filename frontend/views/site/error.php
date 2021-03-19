<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>
<? if(is_array($errors)):?>
    <? foreach ($errors as $field => $error): ?>
        <? if(is_array($error)):?>
            <? foreach ($error as $value): ?>
            <p style="text-align: center">
                <?=$value?>
            </p>
            <? endforeach; ?>
        <? else:?>
    <p style="text-align: center">
        <?=$error?>
    </p>
<? endif; ?>
    <? endforeach; ?>
<? else:?>
    <p style="text-align: center">
        <?=$errors?>
    </p>
<? endif; ?>
</div>
