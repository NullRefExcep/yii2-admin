<?php

namespace nullref\admin;

use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\base\Module as BaseModule;

/**
 * @author    Dmytro Karpovych
 * @copyright 2015 NRE
 */
class Module extends BaseModule implements BootstrapInterface
{
    public $layout = 'main';

    public $defaultRoute = 'main';

    public $adminModelClass = 'nullref\admin\models\Admin';

    public $controllerNamespace = 'nullref\admin\controllers';

    /**
     * Bootstrap method to be called during application bootstrap stage.
     * @param Application $app the application currently running
     */
    public function bootstrap($app)
    {
        \Yii::$app->setComponents(['admin' => [
            'class' => 'yii\web\User',
            'identityClass' => $this->adminModelClass,
        ]]);
    }

    public function init()
    {
        $this->setLayoutPath('@vendor/nullref/yii2-admin/src/views/layouts');
        parent::init();
    }

}