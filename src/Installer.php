<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2015 NRE
 */

namespace nullref\admin;

use nullref\core\components\ModuleInstaller;

class Installer extends ModuleInstaller
{
    public function getModuleId()
    {
        return 'admin';
    }
}