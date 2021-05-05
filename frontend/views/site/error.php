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
<?php if(is_array($errors)):?>
    <?php foreach ($errors as $field => $error): ?>
        <?php if(is_array($error)):?>
            <?php foreach ($error as $value): ?>
            <p style="text-align: center">
                <?=$value?>
            </p>
            <?php endforeach; ?>
        <?php else:?>
    <p style="text-align: center">
        <?=$error?>
    </p>
<?php endif; ?>
    <?php endforeach; ?>
<?php else:?>
    <p style="text-align: center">
        <?=$errors?>
    </p>
<?php endif; ?>
</div>
