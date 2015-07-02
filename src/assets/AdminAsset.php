<?php

namespace nullref\admin\assets;

use yii\web\AssetBundle;

/**
 * @author    Dmytro Karpovych
 * @copyright 2015 NRE
 */
class AdminAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/admin/main.css',
    ];
    public $js = [
        'js/admin/scripts.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\web\YiiAsset',
    ];
} 