<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/style.css',
        'lib/fancybox/source/jquery.fancybox.css',
    ];
    public $js = [
        'js/main.js',
        'js/jquery.form.js',
        'js/notify.min.js',
        'js/counters.js',
        'lib/fancybox/source/jquery.fancybox.pack.js',
        'js/jquery.dcjqaccordion.2.9.js',
        'js/jquery.cookie.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
}
