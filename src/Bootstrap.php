<?php
namespace nullref\admin;

use nullref\admin\components\AccessControl;
use nullref\admin\models\AdminQuery;
use yii\base\Module as BaseModule;
use nullref\core\interfaces\IAdminController;
use Yii;
use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\base\Controller;
use yii\base\Event;
use yii\console\Application as ConsoleApplication;
use yii\gii\Module as Gii;
use yii\i18n\PhpMessageSource;
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
        /** @var Module $module */
        if ((($module = $app->getModule('admin')) == null) || !($module instanceof Module)) {
            return;
        };

        $class = 'nullref\admin\models\Admin';

        $definition = $module->adminModel;
        if ($module->enableRbac) {
            $module->setComponents([
                'authManager' => $module->authManager,
                'roleContainer' => $module->roleContainer,
            ]);
        }

        Yii::$container->set($class, $definition);

        $className = is_array($definition) ? $definition['class'] : $definition;

        Event::on(AdminQuery::className(), AdminQuery::EVENT_INIT, function (Event $e) use ($class, $className) {
            if ($e->sender->modelClass == $class) {
                $e->sender->modelClass = $className;
            }
        });

        /** I18n */
        if (!isset($app->get('i18n')->translations['admin*'])) {
            $app->i18n->translations['admin*'] = [
                'class' => PhpMessageSource::className(),
                'basePath' => '@nullref/admin/messages',
            ];
        }

        if ($app instanceof WebApplication) {
            Yii::$app->setComponents(['admin' => [
                'class' => 'nullref\admin\components\User',
                'identityClass' => $className,
                'loginUrl' => ['admin/login'],
            ]]);
            $app->urlManager->addRules(['/admin/login' => '/admin/main/login']);
            $app->urlManager->addRules(['/admin/logout' => '/admin/main/logout']);


            Event::on(BaseModule::className(), BaseModule::EVENT_BEFORE_ACTION, function () use ($module) {
                if (Yii::$app->controller instanceof IAdminController) {
                    /** @var Controller $controller */
                    $controller = Yii::$app->controller;

                    $controller->layout = $module->layout;
                    if ($controller->module != $module) {
                        $controller->module->setLayoutPath($module->getLayoutPath());
                    }
                    if (!isset($controller->behaviors()['access'])) {
                        $controller->attachBehavior('access', AccessControl::className());
                    }
                    Yii::$app->errorHandler->errorAction = $module->errorAction;
                }
            });


        } elseif ($app instanceof ConsoleApplication) {
            if ($module !== null) {
                /** @var Module $module */
                if ($module->enableRbac) {
                    $module->controllerMap['rbac'] = [
                        'class' => 'nullref\admin\console\RbacController',
                    ];
                }
            }
        }

        Event::on(Module::className(), Module::EVENT_BEFORE_INIT, function (Event $event) use ($app) {
            $module = $event->sender;
            /** @var Module $module */
            if ($module->enableRbac) {
                if ($app instanceof ConsoleApplication) {
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
                $gii->generators['stuff'] = [
                    'class' => 'nullref\admin\generators\stuff\Generator',
                    'templates' => [
                        'default' => '@nullref/admin/generators/stuff/default',
                    ]
                ];
            });
        }
    }
}
