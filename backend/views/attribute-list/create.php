<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\AttributeList */

$this->title = Yii::t('app', 'Create Attribute List');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Attribute Lists'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="attribute-list-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
