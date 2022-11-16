<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Code */

$this->title = Yii::t('app', 'Create Code');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Codes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="code-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
