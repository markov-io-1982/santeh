<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $css_version = 1;

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/main.css',
        'lib/css/font-awesome.min.css',
        'lib/woothemes/flexslider.css',
        'lib/fancybox/source/jquery.fancybox.css',
        'lib/jquery-ui/jquery-ui.min.css'
    ];
    public $js = [
        'lib/woothemes/jquery.flexslider-min.js',
        'lib/fancybox/source/jquery.fancybox.pack.js',
        'lib/noty/js/noty/packaged/jquery.noty.packaged.min.js',
        'lib/jquery-ui/jquery-ui.min.js',
        'js/main.js',
        'js/cart.js',
        'js/jquery.dcjqaccordion.2.9.js',
        'js/jquery.cookie.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];

}
