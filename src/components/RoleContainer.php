<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2015 NRE
 */

namespace nullref\admin\components;

use nullref\core\interfaces\IRoleContainer;
use Yii;
use yii\rbac\BaseManager;

class RoleContainer implements IRoleContainer
{
    const ADMIN = 'admin';

    /**
     * @param BaseManager $authManger
     * @return \yii\rbac\Role[]
     */
    public function getRoles(BaseManager $authManger)
    {
        return [
            self::ADMIN => $authManger->createRole(self::ADMIN),
        ];
    }

    /**
     * @return array
     */
    public function getTitles()
    {
        return [
            self::ADMIN => Yii::t('admin', 'Admin'),
        ];
    }

} 