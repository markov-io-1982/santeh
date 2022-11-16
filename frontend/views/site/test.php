<?php

use frontend\widgets\CartWidget;
use frontend\widgets\CategoryWidget;
use frontend\widgets\MenuWidget;


/* vars */


?>
<div class="container">
    <div class="col-md-3">

        <!-- Widget Menu -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-bars"></i> <a href="/products">Каталог</a> <?php // echo Yii::t('app', 'Categories') ?>
            </div>

            <ul class="catalog category-products">
                <?= MenuWidget::widget(['tpl' => 'menu']) ?>
            </ul>
        </div>
        <!--/ Widget Menu -->
        <?= CategoryWidget::widget() ?>

    </div><!-- /.col-md-3 -->

    <div class="col-md-9">


        jkdshfjkdskj
        jkdshfjkdskj
        jkdshfjkdskj
        jkdshfjkdskj
        jkdshfjkdskj
        jkdshfjkdskj
        jkdshfjkdskj
        jkdshfjkdskj
        jkdshfjkdskj
        jkdshfjkdskj
        jkdshfjkdskj
        jkdshfjkdskj
        jkdshfjkdskj
        jkdshfjkdskj
        jkdshfjkdskj
        jkdshfjkdskj
        jkdshfjkdskj
        jkdshfjkdskj
        jkdshfjkdskj
        jkdshfjkdskj
        jkdshfjkdskj
        jkdshfjkdskj
    </div>
</div>
