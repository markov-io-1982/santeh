<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

use common\models\Price;

use frontend\models\ProductCombination;

/* @var $this yii\web\View */

//print_r($categories_arr);
//die;


$this->title = \frontend\models\S::getCont('site_seo_title');

$this->registerMetaTag([
  'name' => 'description',
  'content' => \frontend\models\S::getCont('site_seo_description')
]);
$this->registerMetaTag([
  'name' => 'keywords',
  'content' => \frontend\models\S::getCont('site_seo_keywords')
]);

$this->registerLinkTag([
  'rel' => 'canonical',
  'href' => (\frontend\models\S::getCont('site_seo_canonical') == '') ? Url::canonical() : \frontend\models\S::getCont('site_seo_canonical')
]);

?>
<div id="myCarousel" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->

  <?php
    $slides = \backend\models\Slideshow::find()->where(['status' => 1])->orderBy('sort_position')->all();
  ?>

  <ol class="carousel-indicators">
    <?php for($i = 0; $i < count($slides); $i++): ?>
      <li data-target="#myCarousel" data-slide-to="<?= $i ?>" class="<?= ($i==0) ? 'active': ''; ?>"></li>
    <?php endfor; ?>
  </ol>

  <div class="carousel-inner" role="listbox">
    <?php $active = true; ?>
    <?php foreach ( $slides as $slide ): ?>
      <?php
        $name = 'name_'.Yii::$app->language;
        $description = 'description_'.Yii::$app->language;
        $link_title = 'link_title_'.Yii::$app->language;
      ?>

      <div class="item carousel-item <?= ($active==true) ? 'active': ''; ?>">
        <?= Html::img('@web/'.$slide->img, ['class' => '', 'alt' => $slide->$name]) ?>
        <div class="container">
          <div class="carousel-caption">
            <?php if(!empty($slide->$name)): ?>
              <h1><?= $slide->$name ?></h1>
            <?php endif; ?>
            <?php if(!empty($slide->$description)): ?>
              <p style="text-shadow: 1px 1px 1px gray;"><?= $slide->$description ?></p>
            <?php endif; ?>
            <?php if(!empty($slide->$link_title) && !empty($slide->link_url)): ?>
              <p>
                <?= Html::a($slide->$link_title, [$slide->link_url], ['class' => 'btn btn-lg btn-app-default', 'role' => 'button']) ?>
              </p>
            <?php endif; ?>
          </div>
        </div>
      </div>
    <?php $active = false; ?>
    <?php endforeach; ?>

  </div>


  <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>

<div class="container">

    <div class="site-index">

      <div class="row categories-main">
        <?php foreach ($categories as $one_category): ?>

          <?php
            $name = 'name_'.Yii::$app->language;
            $description = 'description_'.Yii::$app->language;
          ?>

          <div class="col-sm-4">
            <a href="products/<?= $one_category->slug ?>" title="<?= strip_tags($one_category->$description) ?>">
            	<h3><?= $one_category->$name ?></h3>
              <div class="box-category box text-center category-main" style="background-image: url('<?= Yii::$app->request->baseUrl.'/'.$one_category->img?>');">
                  <!--<div><?php //echo $one_category->$description ?></div>-->
              </div>
            </a>
          </div>
        <?php endforeach ?>
      </div>

      <?php
        $index_products = ArrayHelper::index($products, null, 'promo_status_id');
      ?>

      <?php if(count($index_products) > 0): ?>

        <?php foreach ($promo_statuses as $status): ?>

          <?php if(isset($index_products[$status->id]) ): ?>

            <div class="main-block box row" style="padding-bottom: 50px;">

              <div class="block-title">
                <h1><?= $status->$name ?></h1>
                <span class="title-bottom"></span>
              </div>

              <div class="clearfix"></div>

              <div class="col-md-12">

                <div class="status<?= $status->id ?>">

                  <ul class="slides">

                    <?php foreach ($products as $product): ?>
                      <?php if($product->promo_status_id == $status->id): ?>
                        <?php if($product->promo_status_id == 1 && $product->promo_date_end > date('Y-m-d H:i:s')) { continue;} ?>
                        <?php
                            $name = 'name_'.Yii::$app->language;
                            $url = 'products/'. $categories_arr[$product->category_id] .'/'. $product->slug;

                            $count_product = $product->quantity - $product->reserve;
                            $count_product_with_comb = $count_product;

                            $product_price = $product->price;

                            $product_combinations = ProductCombination::getProductCombinationArrayToProductID($product->id);

                            $product_comb_price = [];
                            $product_comb_visible = [];
                            if (count($product_combinations) > 0) {
                                foreach ($product_combinations as $product_comb_item) {
                                    $product_comb_item_quantity = $product_comb_item['quantity'] - $product_comb_item['reserve'];
                                    if($product_comb_item_quantity > 0) {
                                        $product_comb_visible[] = $product_comb_item;
                                        $product_comb_price[] = $product_comb_item['price'];
                                    }
                                }
                                if (count($product_comb_visible) > 0) {
                                    $count_product_with_comb = $product_comb_visible[0]['quantity']-$product_comb_visible[0]['reserve'];
                                }
                                if(!empty($product_comb_price)) {
                                    sort($product_comb_price);
                                    $product_price = $product_comb_price[0];
                                }
                            }
                        ?>
                            <li style="position:relative; overflow: hidden;height: 350px;">
                              <a href="<?= $url ?>">
                                <?= Html::img('@web/'.$product->img, ['style' => 'width: 100%;']) ?>
                              </a>
                              <div class="flex-caption text-center">
                                <h4 class="flex-head"><?= Html::a($product->$name, [ $url ]) ?> </h4>
                                <p>
                                  <?php if ($product->price_old != 0 && count($product_comb_visible) == 0): ?>
                                    <del><?= Price::getPrice($product->price_old) ?> <?= Price::getCurrency() ?></del>
                                  <?php endif; ?>
                                  <?= count($product_comb_visible) > 0 ? ' от ':'' ?>
                                  <span class="flex-price">
                                    <?= Price::getPrice($product_price) ?> <?= Price::getCurrency() ?>
                                  </span>
                                </p>

                              </div>
                            </li>

                      <?php endif; ?>
                    <?php endforeach ?>

                  </ul>

                </div>

              </div>

            </div>

            <script>
              // Can also be used with $(document).ready()
              $(window).load(function() {
                $('.status<?= $status->id ?>').flexslider({
                  animation: "slide",
                  animationLoop: false,
                  itemWidth: 210,
                  itemMargin: 5,
                  minItems: 2,
                  maxItems: 4
                });
              });
            </script>

          <?php endif; ?>

        <?php endforeach; ?>

      <?php endif; ?>

    </div> <!-- /.site-index -->

</div>