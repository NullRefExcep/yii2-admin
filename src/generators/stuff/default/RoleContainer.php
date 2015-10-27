<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2015 NRE
 */
echo "<?php\n";
?>
namespace app\components;

use nullref\admin\components\RoleContainer as BaseRoleContainer;


class RoleContainer extends BaseRoleContainer
{
    const MANAGER = 'manager';

    /**
    * @param BaseManager $authManger
    * @return \yii\rbac\Role[]
    */
    public function getRoles(BaseManager $authManger)
    {
        return [
            self::ADMIN => $authManger->createRole(self::ADMIN),
            self::MANAGER => $authManger->createRole(self::MANAGER),
        ];
    }

    /**
    * @return array
    */
    public function getTitles()
    {
        return [
            self::ADMIN => Yii::t('admin', 'Admin'),
            self::MANAGER => Yii::t('admin', 'Manager'),
        ];
    }
}

