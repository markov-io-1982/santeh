<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ProductCombination */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Product Combination',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Product Combinations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="product-combination-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
