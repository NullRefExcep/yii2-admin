<?php

namespace nullref\admin;

use nullref\admin\components\IMenuBuilder;
use nullref\core\interfaces\IAdminModule;
use Yii;
use yii\base\InvalidConfigException;
use yii\base\Module as BaseModule;

/**
 * @author    Dmytro Karpovych
 * @copyright 2015 NRE
 */
class Module extends BaseModule implements IAdminModule
{
    public $layout = 'main';

    public $defaultRoute = 'main';

    public $adminModel = 'nullref\admin\models\Admin';

    public $enableRbac = false;

    public $authManager = [
        'class' => 'yii\rbac\PhpManager',
    ];

    public static function getAdminMenu()
    {
        return [
            'label' => Yii::t('admin', 'Dashboard'),
            'url' => ['/admin/main'],
            'icon' => 'dashboard',
        ];
    }

    public function init()
    {
        parent::init();
        $this->setLayoutPath('@vendor/nullref/yii2-admin/src/views/layouts');
        if ((($builder = $this->get('menuBuilder', false)) !== null) && (!($builder instanceof IMenuBuilder))) {
            throw new InvalidConfigException('Menu builder must implement IMenuBuilder interface');
        }
    }

}