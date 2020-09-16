<?php


namespace app\assets;

use yii\web\AssetBundle;

class MyAppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'web/css/main.css',
    ];



}