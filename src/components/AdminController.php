<?php

namespace nullref\admin\components;

use nullref\admin\Module;
use Yii;
use yii\web\Controller;

/**
 * @author    Dmytro Karpovych
 * @copyright 2015 NRE
 */
class AdminController extends Controller
{
    public function init()
    {
        /** @var Module $module */
        $module = Yii::$app->getModule('admin');
        $this->layout = $module->layout;
        $this->module->setLayoutPath($module->getLayoutPath());
        parent::init();
    }

} 