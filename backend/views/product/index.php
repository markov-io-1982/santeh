<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\StringHelper;

use backend\models\Category;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Products');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('<i class="fa fa-plus"></i>  '.Yii::t('app', 'Create Product'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'id',
            [
                'format' => 'raw',
                'value' => function($data){
                    if ($data->img == '') {
                        return null;
                    } else {
                        return Html::img('../../frontend/web/' . $data->img, [
                            'style' => 'width:36px;'
                        ]);
                    }
                },
            ],
            [
                'attribute'=> 'name_'.Yii::$app->language,
                'label' => Yii::t('app', 'Name'),
                //'format' => 'text',
                //'contentOptions' => ['title' => 'name_'.Yii::$app->language ],
                /*
                'value' => function ($data) {
                    $name = 'name_'.Yii::$app->language;
                    return (strlen($data->$name) > 100) ? substr($data->$name, 0, 100) . '...' : $data->$name;
                },*/
                'format' => 'raw',
                'value' => function ($data) {
                    $name = 'name_'.Yii::$app->language;
                    return Html::tag('div', StringHelper::truncate($data->$name, 50), ['data-toggle'=>'tooltip', 'title'=>$data->$name]);
                },
                //'contentOptions' => ['style' => 'max-width:400px; overflow:hidden;'],
            ],
            [
                'attribute'=>'kode',
                'label'=> 'Код',
                'value' => 'kode',
            ],
            [
                'attribute'=>'category_id',
                'value' => 'category.name_'.Yii::$app->language,
                'filter'=>ArrayHelper::map(Category::find()->asArray()->all(), 'id', 'name_'.Yii::$app->language),
            ],
            // 'sort_position',
            // 'intro_text_en',
            // 'intro_text_ru',
            // 'intro_text_ua',
            'price',
            // 'price_old',
            //'quantity',
            // 'min_order',
            // 'reserve',
            // 'promo_status_id',
            // 'promo_date_end',
            // 'stock_status_id',
            //'on_main',
            // 'slug',
            [
                'attribute'=>'status',
                'label'=> 'Публ.',
                'filter'=> [1 => Yii::t('app', 'Active'), 0 => Yii::t('app', 'Inactive')],
                //'filter'=> false,
                'format' => 'html',
                'value' => function ($model) {
                    return $status = ($model->status == 1) ? '<i style="color:green;" class="fa fa-check"></i>' : '<i style="color:red;" class="fa fa-minus"></i>' ;
                },
                //'contentOptions' => ['style' => 'width:10px; max-width:10px;'],
                //'filterInputOptions' => ['style' => 'width:10px; max-width:10px;'],
                //'headerOptions' => ['style' => 'width:10px'],
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a(
                        '<i class="fa fa-eye"></i>', $url, ['class' => 'btn btn-default', 'title' => Yii::t('app', 'View')]);
                    },
                    'update' => function ($url,$model) {
                        return Html::a(
                        '<i class="fa fa-edit"></i>', $url, ['class' => 'btn btn-info', 'title' => Yii::t('app', 'Edit')]);
                    },
                    'delete' => function ($url,$model,$key) {
                        return Html::a('<i class="fa fa-trash"></i>', $url, ['class' => 'btn btn-danger', 'data' => ['confirm' => Yii::t('app', 'Are you sure you want to delete this item?'), 'method' => 'post'], 'title' => Yii::t('app', 'Delete')]);
                    },
                ],
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
