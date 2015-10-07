<?php
namespace nullref\admin;

use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\base\Event;
use yii\console\Application as ConsoleApplication;
use yii\web\Application as WebApplication;
use yii\gii\Module as Gii;

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

            /** Rules for login/logout */
            $app->urlManager->addRules(['/admin/login' => '/admin/main/login']);
            $app->urlManager->addRules(['/admin/logout' => '/admin/main/logout']);

            $adminModel = 'nullref\admin\models\Admin';

            $modules = $app->getModules();

            /** If adminModel was overridden */
            if (isset($modules['admin']) && isset($modules['admin']['adminModel'])) {
                $adminModel = $modules['admin']['adminModel'];
            }

            /** config admin user model */
            \Yii::$app->setComponents(['admin' => [
                'class' => 'nullref\admin\components\User',
                'identityClass' => $adminModel,
                'loginUrl' => ['admin/login'],
            ]]);

        }

        Event::on(Module::className(), Module::EVENT_BEFORE_INIT, function (Event $event) use ($app) {
            $module = $event->sender;
            /** @var Module $module */
            if ($module->enableRbac) {
                if ($app instanceof ConsoleApplication){
                    $module->controllerMap['rbac'] = [
                        'class' => 'nullref\admin\console\RbacController',
                    ];
                }
                $module->setComponents([
                    'authManager' => $module->authManager,
                    'roleContainer' => $module->roleContainer,
                ]);
            }
        });

        if (YII_ENV_DEV) {
            Event::on(Gii::className(), Gii::EVENT_BEFORE_ACTION, function (Event $event) {
                /** @var Gii $gii */
                $gii = $event->sender;
                $gii->generators['crud'] = [
                    'class' => 'yii\gii\generators\crud\Generator',
                    'templates' => [
                        'admin-crud' => '@nullref/admin/generators/crud/admin',
                    ]
                ];
            });
        }

    }
}
