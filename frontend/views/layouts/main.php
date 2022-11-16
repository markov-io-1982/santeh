<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
//use frontend\assets\AppAsset;
use common\widgets\Alert;
use frontend\models\Cart;
use yii\widgets\Pjax;

use common\models\Configs;

frontend\assets\AppAsset::register($this);
Yii::$app->response->headers->set('Cache-Control', 'public, max-age=3600');

//AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,500,700,300,100&v=1' rel='stylesheet'
          type='text/css'/>
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<!--/ Top navbar start  -->
<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Configs::byCode('site_name'),
        'brandUrl' => '/'.Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-default',
            'style' => 'border-radius: 0px;margin-bottom:10px;'
        ],
    ]);
    $cart = Cart::initCart();

    ?>

    <div class="top-menu-layouts-search row ">
        <div class="navbar-buttons navbar-right">
            <div class="navbar-collapse collapse right" id="basket-overview">
                <div class="work_times_wrapper">
                    <div class="work_times_title">
                        <?= Configs::byCode('work_times_title') ?>
                    </div>
                    <div class="work_times">
                        <?= Configs::byCode('work_times') ?>
                    </div>
                </div>
                <span class="nav_phone"><i
                            class="fa fa-phone-square fa-lg"></i> <?= Configs::byCode('nav_phone') ?></span>
                <span class="nav_phone"><i
                            class="fa fa-phone-square fa-lg"></i> <?= Configs::byCode('nav_phone_2') ?></span>

                <a href="/cart" class="btn navbar-btn btn-default">
                    <i class="fa fa-shopping-cart"></i>
                    <span class="count">
	                    <?= Yii::t('app', 'items in cart') ?>:
	                    <span title="Перейти в корзину" class="app-count-product"
                              data-totalprice="<?= \common\models\Price::getPrice($cart['total_price']) ?>"><?= $cart['count'] ?></span>
	                </span>
                </a>
            </div>
        </div>
    </div>
    
    
    <!--  Top layout menu  -->

    <div class="top-menu-layouts row">
        <?php
        $menu = \backend\models\Menu::find()->where(['status' => 1])->orderBy('sort_position')->all();
        $menuItems = [];
        $name = 'name_' . Yii::$app->language;
        foreach ($menu as $menu_item) {
            if ($menu_item->parent_id == 0) {
                $item = [];
                $item['label'] = $menu_item->$name;
                $item['url'] = $menu_item->url;//Yii::$app->request->baseUrl .
                foreach ($menu as $m) {
                    if ($m->parent_id == $menu_item->id) {
                        $items['label'] = $m->$name;;
                        $items['url'] = $m->url;
                        $item['items'][] = $items;
                    }
                }
                $menuItems[] = $item;
            }
        }

        foreach ($menuItems as $item) {
            $menuTopArr[] = ['label' => $item['label'], 'url' => [$item['url']]];
        };

        echo Nav::widget([
            'options' => ['class' => 'navbar-nav'],
            'items' => $menuTopArr,
        ]);
        
        
        echo '   <div id="search_wrapper">
            <form action="/search" method="get">
                <span class="input-group search_form_inner">
                  <input type="text" id="search-input" class="form-control" name="q" placeholder="' . Yii::t('app', 'Search') . '..."/>
                  <span class="input-group-btn">
                    <button class="btn btn-default search-btn" type="submit">
                        <i class="fa fa-search"></i>
                    </button>
                  </span>
                </span>
            </form>
        </div>';

        $label = '';
        foreach (Yii::$app->params['currencies'] as $key => $item) {
            $menuTopParam[] = "<li data-curr='$key' class='cash'><a href=''>$item</a></li>";//['label' => $item, 'url' => ''];
            $label .= ($key == Yii::$app->params['currency']) ? $item : '';
        }
        echo Nav::widget([
            'options' => ['class' => 'nav navbar-nav navbar-right'],
            'items' => [
                ['label' => (Yii::$app->request->cookies->get('curr')) ? strtoupper(Yii::$app->request->cookies->get('curr')) : $label,
                    'items' => $menuTopParam,
                ],
            ],
        ]); ?>
    </div>
    <!--/  Tor layout menu  -->
    <?php NavBar::end(); ?>
    <!--/ Top navbar end  -->

    <div class="container">

        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>

    </div>


    <?= $content ?>


</div>

<footer class="footer">
    <div class="container">
        <div class="pull-left">
            <span style="display: block">
                <?= Html::a(Yii::t('app', 'Contact'), ['/contact'], ['title', Yii::t('app', 'Contact'), 'style' => 'margin-right: 20px;']); ?>
                <i class="fa fa-phone-square fa-lg"></i> <?= Configs::byCode('footer_phone') ?>
            </span>
            <span style="display: block">
            <?= Configs::byCode('footer_left') ?>
            <?php
            echo '2017';
            if ('2017' != date('Y')) {
                echo ' - ' . date('Y');
            }
            ?>
            </span>
        </div>

        <div class="pull-right">

            <span class="soc-but">
                <span>
                    <?= Yii::t('app', 'We are in social networks') ?>:
                </span>
                <span>
                    <?= Html::a('<i class="fa fa-facebook"></i>', [Configs::byCode('link_fb')], ['title' => Yii::t('app', 'Facebook')]) ?>
                </span>
            </span>

            <span>
                <?= Configs::byCode('footer_right') ?>
            </span>

            <div>
                <a href="http://urandev.com" target="_blank" title="Интернет-магазин разработан в веб-студии URAN">Интернет-магазин
                    разработан в веб-студии URAN</a>
            </div>

        </div>
    </div>
</footer>

<?= \frontend\models\Code::getContent('fastcallagent') ?>

<?= \frontend\models\Code::getContent('jivosite') ?>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
