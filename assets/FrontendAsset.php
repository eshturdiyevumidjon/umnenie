<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets; 

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class FrontendAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        //'css/site.css',
        'frontend/css/animate.css',
        'frontend/owlcarousel/owl.carousel.min.css',
        'frontend/owlcarousel/owl.theme.default.min.css',
        'frontend/jquery.fancybox.min.css',
        'frontend/style.css',

    ];
    public $js = [
        'frontend/script/jquery.min.js',
        'frontend/script/wow.min.js',
        'frontend/owlcarousel/owl.carousel.min.js',
        'frontend/main.js',
        'frontend/jquery.fancybox.min.js',

    ];
    public $depends = [ 
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
