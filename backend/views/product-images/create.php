<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\ProductImages */

$this->title = Yii::t('app', 'Create Product Images');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Product Images'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-images-create">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
