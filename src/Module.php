<?php

namespace nullref\admin;

use nullref\core\interfaces\IAdminModule;
use Yii;
use yii\base\Module as BaseModule;

/**
 * @author    Dmytro Karpovych
 * @copyright 2015 NRE
 */
class Module extends BaseModule implements IAdminModule
{
    public static function getAdminMenu()
    {
        return [
            'label' => Yii::t('admin', 'Dashboard'),
            'url' => ['/admin/main'],
            'icon' => 'dashboard',
        ];
    }

    public $layout = 'main';

    public $defaultRoute = 'main';

    public $adminModelClass = 'nullref\admin\models\Admin';

    public function init()
    {
        parent::init();
        \Yii::$app->setComponents(['admin' => [
            'class' => 'yii\web\User',
            'identityClass' => $this->adminModelClass,
        ]]);
        $this->setLayoutPath('@vendor/nullref/yii2-admin/src/views/layouts');
    }

}