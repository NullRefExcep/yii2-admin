<?php
namespace nullref\admin\widgets;

use nullref\core\interfaces\IAdminModule;
use nullref\sbadmin\widgets\MetisMenu;
use Yii;
use yii\base\Widget;

/**
 * @author    Dmytro Karpovych
 * @copyright 2015 NRE
 */
class Menu extends Widget
{
    public function run()
    {
        $methodName = 'getAdminMenu';
        $items = [];
        foreach (Yii::$app->modules as $module) {
            if ($module instanceof IAdminModule) {
                $items[] = $module::getAdminMenu();
            } elseif (is_array($module) && isset($module['class'])) {
                $class = $module['class'];
                $reflection = new \ReflectionMethod($class, $methodName);
                if ($reflection->isStatic() && $reflection->isPublic()) {
                    $items[] = call_user_func(array($class, $methodName));
                }
            }
        }

        return MetisMenu::widget(['items' => $items]);
    }

} 