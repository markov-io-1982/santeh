<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProductDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Product Details');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-detail-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Product Detail'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'product_id',
            // [
            //     'attribute' => 'description_'.Yii::$app->language,
            //     'format' => 'text',
            //     'headerOptions' => ['width' => '200px'],
            //     'options' => ['width' => '200px']
            //     //'label' => 'Name',
            // ],
            // 'description_ru:ntext',
            // 'description_ua:ntext',
            // 'complectation_en:ntext',
            // 'complectation_ru:ntext',
            // 'complectation_ua:ntext',
            // 'seo_title_en',
            // 'seo_title_ru',
            // 'seo_title_ua',
            // 'seo_description_en',
            // 'seo_description_ru',
            // 'seo_description_ua',
            // 'seo_keywords_en',
            // 'seo_keywords_ru',
            // 'seo_keywords_ua',
            // 'buy',
            // 'count_views',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
