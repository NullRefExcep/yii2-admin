<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2015 NRE
 */

namespace nullref\admin;

use nullref\core\components\ModuleInstaller;
use yii\helpers\Console;

class Installer extends ModuleInstaller
{
    public function getModuleId()
    {
        return 'admin';
    }

    public function install()
    {
        parent::install();
        if (Console::confirm('Create assets files?')) {
            try {
                $this->createFile('@webroot/js/admin/scripts.js');
                echo 'File @webroot/js/admin/scripts.js was created' . PHP_EOL;

                $this->createFile('@webroot/css/admin/main.css');
                echo 'File @webroot/css/admin/main.css was created' . PHP_EOL;
            } catch (\Exception $e) {
                echo $e->getMessage() . PHP_EOL;
            }
        }
    }

    protected function addToConfig()
    {
        $path = $this->getConfigPath();
        $config = require($path);

        $config['admin'] = $this->getConfigArray();
        $config['user'] = ['class' => 'dektrium\user\Module'];

        $this->writeArrayToFile($this->getConfigPath(), $config);
    }

}