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
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'web/css/ie.css',
    ];
    public $cssOptions = ['condition' => 'lte IE8'];
    public $js = [
        'js/functions.js',
//        '//vk.com/js/api/openapi.js?63'
    ];
    public $depends = [
        'app\assets\MyAppAsset',
//        'yii\bootstrap\BootstrapAsset',
    ];
}
