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
        'nullref\sbadmin\assets\SBAdminAsset',
    ];

    public static function register($view)
    {
        if (class_exists('\app\assets\AdminAsset')) {
            call_user_func(['\app\assets\AdminAsset', 'register'], $view);
        }
        return parent::register($view);
    }

} 