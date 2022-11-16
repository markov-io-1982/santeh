<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\HtmlBlock */

$this->title = Yii::t('app', 'Create Html Block');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Html Blocks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="html-block-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
