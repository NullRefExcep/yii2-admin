<?php

namespace nullref\admin;

use nullref\admin\components\AccessControl;
use nullref\admin\interfaces\IMenuBuilder;
use nullref\core\components\Module as BaseModule;
use nullref\core\interfaces\IAdminModule;
use nullref\core\interfaces\IHasMigrateNamespace;
use Yii;
use yii\base\InvalidConfigException;

/**
 * @author    Dmytro Karpovych
 * @copyright 2015 NRE
 */
class Module extends BaseModule implements IAdminModule, IHasMigrateNamespace
{
    public $layout = 'main';

    public $errorAction = '/admin/main/error';

    public $defaultRoute = 'main';

    public $adminComponent = 'admin';

    public $adminModel = 'nullref\admin\models\Admin';

    public $enableRbac = false;

    public $globalWidgets = [];

    public $accessControl;

    /** @var array */
    public $authManager = [
        'class' => 'yii\rbac\PhpManager',
        'itemFile' => '@app/rbac/admin_items.php',
        'assignmentFile' => '@app/rbac/admin_assignments.php',
        'ruleFile' => '@app/rbac/admin_rules.php',
    ];

    /**
     * @var array
     */
    public $roleContainer = [
        'class' => 'nullref\admin\components\RoleContainer',
    ];

    /**
     * @return array
     */
    public static function getAdminMenu()
    {
        return [
            'label' => Yii::t('admin', 'Dashboard'),
            'url' => ['/admin/main'],
            'icon' => 'dashboard',
        ];
    }

    /**
     * @throws InvalidConfigException
     */
    public function init()
    {
        parent::init();
        $this->addOverrideViewPath();
        $this->setLayoutPath('@vendor/nullref/yii2-admin/src/views/layouts');
        if ((($builder = $this->get('menuBuilder', false)) !== null) && (!($builder instanceof IMenuBuilder))) {
            throw new InvalidConfigException('Menu builder must implement IMenuBuilder interface');
        }
        if ($this->accessControl === null) {
            $this->accessControl = AccessControl::className();
        }
        //@TODO add checking $globalWidgets
    }

    /**
     * Return path to folder with migration with namespaces
     *
     * @param $defaults
     * @return array
     */
    public function getMigrationNamespaces($defaults)
    {
        return ['nullref\admin\migration_ns'];
    }

}