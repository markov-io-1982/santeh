<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = Yii::t('app', 'Contact');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container">
    
    <div class="site-contact box">
        <h1><?= Html::encode($this->title) ?></h1>
        <hr>

        <div>
            <?= \frontend\models\Html::getCont('contact') ?>
        </div>

        <!-- <div class="row"> -->
            <!-- <div class="col-lg-5"> -->
                <?php // $form = ActiveForm::begin(['id' => 'contact-form']); ?>

                    <?php // $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

                    <?php // $form->field($model, 'email') ?>

                    <?php // $form->field($model, 'subject') ?>

                    <?php // $form->field($model, 'body')->textarea(['rows' => 6]) ?>

                    <?php // $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                        //'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                    //]) ?>

                    <div class="form-group">
                        <?php // Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                    </div>

                <?php // ActiveForm::end(); ?>
            <!-- </div> -->
        <!-- </div> -->

    </div>

</div>
