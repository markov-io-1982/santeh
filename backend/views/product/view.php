<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

use backend\models\Category;

/* @var $this yii\web\View */
/* @var $model backend\models\Product */

$name = 'name_'.Yii::$app->language;
$this->title = $model->$name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('<i class="fa fa-edit"></i> '.Yii::t('app', 'Edit'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="fa fa-trash"></i> '.Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#genelar_information" data-toggle="tab"><?= Yii::t('app', 'General information') ?></a></li>
            <li><a href="#otrher_language" data-toggle="tab"><?= Yii::t('app', 'Description in other languages') ?></a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="genelar_information">

                <div class="row">

                    <div class="col-md-8">
                        <?= DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                'id',
                                'kode',
                                'name_'.Yii::$app->language,
                                [
                                    'attribute' => 'category_id',
                                    'value' => Category::getCategoryName($model->category_id)
                                ],
                                'sort_position',
                                // [
                                //     'attribute' => 'intro_text_'.Yii::$app->language,
                                //     'format' => 'html',

                                // ],
                                'price',
                                'price_old',
                                'quantity',
                                'min_order',
                                'reserve',
                                //'promo_status_id',
                                [
                                    'attribute' => 'promo_status_id',
                                    'value' => \backend\models\PromoStatus::getPromoStatusName($model->promo_status_id)
                                ],
                                'promo_date_end',
                                //'stock_status_id',
                                [
                                    'attribute' => 'stock_status_id',
                                    'value' => \backend\models\StockStatus::getStockStatusName($model->stock_status_id)
                                ],
                                'img',
                                //'on_main',
                                [
                                    'attribute' => 'on_main',
                                    'format' => 'html',
                                    'value' => ($model->on_main == 1) ? '<i style="color:green;" class="fa fa-check"></i>' : '<i class="fa fa-minus"></i>',
                                ],
                                'slug',
                                [
                                    'attribute' => 'status',
                                    'format' => 'html',
                                    'value' => ($model->status == 1) ? '<i style="color:green;" class="fa fa-check"></i>' : '<i class="fa fa-minus"></i>',
                                ],
                                //'status',
                            ],
                        ]) ?>

                        <?= DetailView::widget([
                            'model' => $product_detail,
                            'attributes' => [
                                //'id',
                                //'product_id',
                                [
                                    'attribute' => 'description_'.Yii::$app->language,
                                    'format' => 'html',
                                ],
                                [
                                    'attribute' => 'complectation_'.Yii::$app->language,
                                    'format' => 'html',
                                ],
                                'seo_title_'.Yii::$app->language,
                                'seo_description_'.Yii::$app->language,
                                'seo_keywords_'.Yii::$app->language,
                                'buy',
                                'count_views',
                                'seo_canonical_url',
                            ],
                        ]) ?>
                    </div>

                    <div class="col-md-4">
                        <a class="fancybox" rel="gallery1" href="<?= Url::to('../../frontend/web/'.$model->img) ?>" title="">
                            <?= Html::img('../../frontend/web/'.$model->img, ['class' => 'img-responsive', 'alt' => '', 'style' => 'width:100%;']) ?>
                        </a>
                        <div class="row">
                            <?php foreach($product_images as $image): ?>
                            <?php $name = 'name_'.Yii::$app->language ?>
                                <div class="col-md-6" style="">
                                    <a class="fancybox" rel="gallery1" href="<?= Url::to('../../frontend/web/'.$image->url) ?>" title="<?= $image->$name ?>">
                                        <?= Html::img('../../frontend/web/'.$image->url, ['class' => 'img-responsive', 'alt' => $image->$name]) ?>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-12">

                                <div class="box">
                                  <div class="box-header with-border">
                                    <h3 class="box-title"><?= Yii::t('app', 'Product combinations') ?></h3>
                                  </div><!-- /.box-header -->
                                  <div class="box-body">
                                    <table class="table">
                                        <tr>
                                            <th colspan="2"><?= Yii::t('app', 'Product combination') ?></th>
                                            <th><?= Yii::t('app', 'Quant.') ?></th>
                                            <th><?= Yii::t('app', 'Код') ?></th>
                                            <th><?= Yii::t('app', 'Цена') ?></th>
                                            <th colspan="2"><?= Yii::t('app', 'Order number') ?></th>
                                        </tr>
                                        <?php foreach($product_combination as $one_combination): ?>
                                        <?php $visibility = ($one_combination['status'] == 0) ? 'color:gray;' : '' ?>
                                            <tr style="<?= $visibility ?>">
                                                <td><?= $one_combination['attribute'] ?>: <?= $one_combination['attribute_value'] ?></td>
                                                <td><?= ($one_combination['attribute_value_img'] != '') ? Html::img('../../frontend/web/'.$one_combination['attribute_value_img']) : '' ?></td>
                                                <td><?= $one_combination['quantity'] ?></td>
                                                <td><?= $one_combination['kode'] ?></td>
                                                <td><?= $one_combination['price'] ?></td>
                                                <td><?= $one_combination['sort_position'] ?></td>
                                                <td><?= ($one_combination['default_check'] == 1) ? '<i style="color:green;" class="fa fa-check"></i>' : '' ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </table>
                                  </div><!-- /.box-body -->
                                </div><!-- /.box -->

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">

                                <div class="box">
                                  <div class="box-header with-border">
                                    <h3 class="box-title"><?= Yii::t('app', 'Attributes') ?></h3>
                                  </div><!-- /.box-header -->
                                  <div class="box-body">
                                    <table class="table">
                                        <tr>
                                            <th colspan="2"><?= Yii::t('app', 'Attribute') ?></th>
                                            <th><?= Yii::t('app', 'Attribute Value') ?></th>
                                            <th><?= Yii::t('app', 'Order number') ?></th>
                                        </tr>
                                        <?php foreach($relations_attributes as $attr): ?>
                                            <tr>
                                                <td><?= ($attr['img'] != '') ? Html::img('../../frontend/web/'.$attr['img'], ['style' => 'width:36px;']) : '' ?></td>
                                                <td><?= $attr['attribute'] ?></td>
                                                <td><?= $attr['value'] ?></td>
                                                <td><?= $attr['sort'] ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </table>
                                  </div><!-- /.box-body -->
                                </div><!-- /.box -->

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">

                                <div class="box">
                                  <div class="box-header with-border">
                                    <h3 class="box-title"><?= Yii::t('app', 'Related products') ?></h3>
                                  </div><!-- /.box-header -->
                                  <div class="box-body">
                                    <ul>
                                      <?php foreach($relations_product as $id => $rel_product): ?>
                                        <li>
                                          <?= $rel_product ?>
                                        </li>
                                      <?php endforeach; ?>
                                    </ul>
                                  </div><!-- /.box-body -->
                                </div><!-- /.box -->

                            </div>
                        </div>

                    </div>

                </div>

            </div>
            <div class="tab-pane" id="otrher_language">

                <div id="more-detail" style="margin-top:20px;">

                    <?php foreach (Yii::$app->params['languages'] as $key => $language): ?>

                        <?php if ($key == Yii::$app->language) {
                            continue;
                        } ?>

                        <?= DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                //'id',
                                'name_'.$key,
                                // [
                                //     'attribute' => 'intro_text_'.$key,
                                //     'format' => 'html',

                                // ],
                            ],
                        ]) ?>

                        <?= DetailView::widget([
                            'model' => $product_detail,
                            'attributes' => [
                                [
                                    'attribute' => 'description_'.$key,
                                    'format' => 'html',
                                ],
                                [
                                    'attribute' => 'complectation_'.$key,
                                    'format' => 'html',
                                ],
                                'seo_title_'.$key,
                                'seo_description_'.$key,
                                'seo_keywords_'.$key,
                            ],
                        ]) ?>

                    <?php endforeach; ?>

                </div>

            </div>

        </div>

    </div>

</div>