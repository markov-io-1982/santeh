<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\RelationsProductAtribute */

$this->title = Yii::t('app', 'Create Relations Product Atribute');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Relations Product Atributes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="relations-product-atribute-create">

    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
