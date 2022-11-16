<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\DeliveryMethod */

$this->title = Yii::t('app', 'Create Delivery Method');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Delivery Methods'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="delivery-method-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
