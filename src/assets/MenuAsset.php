<?php

namespace nullref\admin\assets;

use yii\web\AssetBundle;

class MenuAsset extends AssetBundle
{
    public $sourcePath = '@nullref/admin/assets';
    public $css = [
        'css/side-sub-menu.css',
    ];
    public $js = [
        'js/submenu.js'
    ];

    public $depends = [
        'nullref\core\assets\ToolsAsset',
    ];

}