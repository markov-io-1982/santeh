<?php

use backend\models\Informers;

$new_orders = Informers::getNewOrders();
$new_orders = ($new_orders > 0) ? ' <small title="Новые заказы" class="label bg-green">+'.$new_orders.'</small>' : '';

$new_standart_orders = Informers::getNewStandartOrders();
$new_standart_orders = ($new_standart_orders > 0) ? ' <small title="Новые обычные заказы" class="label bg-green">+'.$new_standart_orders.'</small>' : '';

$new_orders_wb_pb = Informers::getNewOrdersPbWm();
$new_orders_wb_pb = ($new_orders_wb_pb > 0) ? ' <small title="Новые оплаченые заказы" class="label bg-yellow">+'.$new_orders_wb_pb.'</small>' : '';

$new_one_click_orders = Informers::getNewOneClickOrders();
$new_one_click_orders = ($new_one_click_orders > 0) ? ' <small title="Новые заказы в один клик" class="label bg-green">+'.$new_one_click_orders.'</small>' : '';

$new_reviews = Informers::getNewReviews();
$new_reviews = ($new_reviews > 0) ? ' <small title="Новые отзывы" class="label bg-blue">+'.$new_reviews.'</small>' : '';

?>

<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
<!--         <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>Alexander Pierce</p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div> -->

        <!-- search form -->
<!--         <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form> -->
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'encodeLabels' => false,
                'activateParents'=>true,
                'activeCssClass'=>'active',
                'items' => [
                    //['label' => 'Menu Yii2', 'options' => ['class' => 'header']],
                    //['label' => 'Gii', 'icon' => 'fa fa-file-code-o', 'url' => ['/gii']],
                    //['label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => ['/debug']],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    [
                        'label' => Yii::t('app', 'Shop'),
                        'icon' => 'fa fa-shopping-cart',
                        'url' => '#',
                        'items' => [
                            [
                                'label' => Yii::t('app', 'Attributes'),
                                'icon' => 'fa fa-tags',
                                'url' => '#',
                                'items' => [
                                    [
                                        'label' => Yii::t('app', 'List of attributes'),
                                        'icon' => 'fa fa-tags',
                                        'url' => ['/attribute-list/index'],
                                    ],
                                    [
                                        'label' => Yii::t('app', 'The value of the attribute'),
                                        'icon' => 'fa fa-tag',
                                        'url' => ['/attribute-value/index'],
                                    ],
                                ],
                            ],
                            [
                                'label' => Yii::t('app', 'Categories'),
                                'icon' => 'fa fa-th-large',
                                'url' => ['/category/index'],
                            ],
                            [
                                'label' => Yii::t('app', 'Products'),
                                'icon' => 'fa fa-archive',
                                'url' => ['/product/index'],
                            ],
                            [
                                'label' => Yii::t('app', 'Import XLS'),
                                'icon' => 'fa fa-file-excel-o',
                                'url' => ['/product/import-xls'],
                            ],
                            // [
                            //     'label' => Yii::t('app', 'Products images'),
                            //     'icon' => 'fa fa-file-image-o',
                            //     'url' => ['/product-images/index'],
                            // ],

                            // [
                            //     'label' => Yii::t('app', 'Relations'),
                            //     'icon' => '',
                            //     'url' => '#',
                            //     'items' => [
                            //         [
                            //             'label' => Yii::t('app', 'Products-product'),
                            //             'icon' => 'fa fa-file-code-o',
                            //             'url' => ['/relations-product-product/index'],
                            //         ],
                            //         [
                            //             'label' => Yii::t('app', 'Products-attribute'),
                            //             'icon' => 'fa fa-file-code-o',
                            //             'url' => ['/relations-product-atribute/index'],
                            //         ],
                            //     ]
                            // ],
                        ],
                    ],
                    ['label' => Yii::t('app', 'Slideshow'), 'icon' => 'fa fa-image', 'url' => ['/slideshow/index']],
                    ['label' => Yii::t('app', 'Reviews') . $new_reviews, 'icon' => 'fa fa-comments', 'url' => ['/review/index']],
                    [
                        'label' => Yii::t('app', 'Order') . $new_orders ,
                        'icon' => 'fa fa-shopping-bag',
                        'url' => '#',
                        'items' => [
                            ['label' => Yii::t('app', 'List of Orders') . $new_standart_orders . $new_orders_wb_pb, 'icon' => 'fa fa-file-text-o', 'url' => ['/order/index']],
                            //['label' => Yii::t('app', 'New Orders') . $new_standart_orders . $new_orders_wb_pb, 'icon' => 'fa fa-file-text-o', 'url' => ['/order/new']],
                            ['label' => Yii::t('app', 'One Click Orders') . $new_one_click_orders, 'icon' => 'fa fa-phone', 'url' => ['/order/click']],
                            //['label' => Yii::t('app', 'New One Click Orders') . $new_one_click_orders, 'icon' => 'fa fa-phone', 'url' => ['/order/new-click']],
                            ['label' => Yii::t('app', 'Carts'), 'icon' => 'fa fa-cart-arrow-down', 'url' => ['/cart/index']],
                            [
                                'label' => Yii::t('app', 'Payments'),
                                'icon' => 'fa fa-money',
                                'url' => '#',
                                'items' => [
                                    [
                                        'label' => Yii::t('app', 'Privat24'),
                                        'icon' => '',
                                        'url' => ['/payment-pb/index'],
                                    ],
                                    [
                                        'label' => Yii::t('app', 'WebMoney'),
                                        'icon' => '',
                                        'url' => ['/payment-wm/index'],
                                    ],
                                ]
                            ],
                        ],
                    ],
                    [
                        'label' => Yii::t('app', 'Statuses'),
                        'icon' => 'fa fa-folder-o',
                        'url' => '#',
                        'items' => [
                            ['label' => Yii::t('app', 'Payment methods'), 'icon' => 'fa fa-money', 'url' => ['/payment-method/index']],
                            ['label' => Yii::t('app', 'Order status'), 'icon' => 'fa fa-file-text-o', 'url' => ['/order-status/index']],
                            ['label' => Yii::t('app', 'Delivery method'), 'icon' => 'fa fa-truck', 'url' => ['/delivery-method/index']],
                            [
                                'label' => Yii::t('app', 'Promo status'),
                                'icon' => 'fa fa-gift',
                                'url' => ['/promo-status/index'],
                            ],
                            [
                                'label' => Yii::t('app', 'Stock status'),
                                'icon' => 'fa fa-institution',
                                'url' => ['/stock-status/index'],
                            ],
                        ],
                    ],
                    ['label' => Yii::t('app', 'Pages'), 'icon' => 'fa fa-copy', 'url' => ['/page/index']],
                    [
                        'label' => Yii::t('app', 'Settings'),
                        'icon' => 'fa fa-cogs',
                        'url' => '#',
                        'items' => [
                            ['label' => Yii::t('app', 'Code'), 'icon' => 'fa fa-code', 'url' => ['/code/index'],],
                            ['label' => Yii::t('app', 'Html blocks'), 'icon' => 'fa fa-list-alt', 'url' => ['/html-block/index'],],
                            ['label' => Yii::t('app', 'Settings'), 'icon' => 'fa fa-cog', 'url' => ['/setting/index'],],
                            ['label' => Yii::t('app', 'Variables'), 'icon' => 'fa fa-wrench', 'url' => ['/setting/config'],],
                            ['label' => Yii::t('app', 'Menu'), 'icon' => 'fa fa-bars', 'url' => ['/menu/index'],],
                        ],
                    ],
                ],
            ]
        ) ?>

    </section>

</aside>
