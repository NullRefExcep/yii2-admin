<?php
namespace nullref\admin;

use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\web\Application as WebApplication;

/**
 * @author    Dmytro Karpovych
 * @copyright 2015 NRE
 */
class Bootstrap implements BootstrapInterface
{
    /**
     * Bootstrap method to be called during application bootstrap stage.
     * @param Application $app the application currently running
     */
    public function bootstrap($app)
    {
        if ($app instanceof WebApplication) {
            $class = 'nullref\admin\models\Admin';
            if (($module = $app->getModule('admin'))) {
                /** @var Module $module */
                $class = $module->adminModel;
            }
            \Yii::$app->setComponents(['admin' => [
                'class' => 'yii\web\User',
                'identityClass' => $class,
                'loginUrl' => ['admin/login'],
            ]]);
            $app->urlManager->addRules(['/admin/login' => '/admin/main/login']);
            $app->urlManager->addRules(['/admin/logout' => '/admin/main/logout']);
        }
    }
}
