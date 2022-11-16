<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\ProductCombination */

$this->title = Yii::t('app', 'Create Product Combination');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Product Combinations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-combination-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
