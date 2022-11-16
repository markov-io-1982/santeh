<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;


// if ($exception->statusCode == '404') {
//     $this->title = "Не найдено 404";
// } else {
    $this->title = $name;
//}

?>
<div class="container">
    
    <div class="site-error box text-center">

        <h1><?= Html::encode($this->title) ?></h1>

        <div class="alert alert-danger">
            <?= nl2br(Html::encode($message)) ?>
        </div>

        <p>
            <?= Yii::t('app', 'The above error occurred while the Web server was processing your request') ?>
        </p>
        <p>
            <?= Html::a(Yii::t('app', 'Return to home'), ['/'], ['class' => 'btn btn-default']) ?>
        </p>

    </div>

</div>
