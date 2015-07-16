<?php

namespace nullref\admin\console;

use Yii;
use yii\console\Controller;
use yii\helpers\FileHelper;
use yii\rbac\BaseManager;
use yii\rbac\Role;

/**
 * @author    Dmytro Karpovych
 * @copyright 2015 NRE
 */
class RbacController extends Controller
{
    public function actionInit()
    {
        $dir = Yii::getAlias('@app/rbac');
        if (!file_exists($dir)) {
            FileHelper::createDirectory($dir);
            echo 'RBAC configs dir was created.' . PHP_EOL;
        }

        /** @var BaseManager $authManager */
        $authManager = \Yii::$app->getModule('admin')->get('authManager');
        if ($this->confirm('Configure from role container?')) {
            /** @var Role[] $roles */
            $roles = \Yii::$app->getModule('admin')->get('roleContainer')->getRoles($authManager);
            foreach ($roles as $role) {
                $authManager->add($role);
            }
        } else {
            $file = Yii::getAlias('@app/config/admin_rbac.php');
            if (file_exists($file)) {
                include($file);
            } else {
                echo 'You must create file "@app/config/admin_rbac.php"' . PHP_EOL;
                //@TODO propose to create file
            }
        }

        echo 'RABC was configured' . PHP_EOL;
    }

    public function actionView()
    {
        /** @var BaseManager $authManager */
        $authManager = \Yii::$app->getModule('admin')->get('authManager');
        $roles = $authManager->getRoles();
        echo 'Roles:' . PHP_EOL;
        foreach ($roles as $role) {
            echo "\t Role: " . $role->name . PHP_EOL .
                "\t Data: ";
            print_r($role->data);
            echo PHP_EOL . "\t Description: " . $role->description . PHP_EOL . PHP_EOL;
        }

    }
} 