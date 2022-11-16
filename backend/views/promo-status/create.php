<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\PromoStatus */

$this->title = Yii::t('app', 'Create Promo Status');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Promo Statuses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="promo-status-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
