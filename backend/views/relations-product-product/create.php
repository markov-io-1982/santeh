<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\RelationsProductProduct */

$this->title = Yii::t('app', 'Create Relations Product Product');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Relations Product Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="relations-product-product-create">

    <h1><?php // Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
