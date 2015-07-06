<?php
namespace nullref\admin\widgets;

use nullref\admin\components\IMenuBuilder;
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
    protected $items = [];

    public function init()
    {
        parent::init();

        $methodName = 'getAdminMenu';
        foreach (Yii::$app->modules as $id => $module) {
            if ($module instanceof IAdminModule) {
                $this->items[$id] = $module::getAdminMenu();
            } elseif (is_array($module) && isset($module['class'])) {
                $class = $module['class'];
                $reflection = new \ReflectionMethod($class, $methodName);
                if ($reflection->isStatic() && $reflection->isPublic()) {
                    $this->items[$id] = call_user_func(array($class, $methodName));
                }
            }
        }
        /** @var $builder IMenuBuilder */
        if (($builder = Yii::$app->getModule('admin')->get('menuBuilder', false)) !== null) {
            $this->items = $builder->build($this->items);
        }
    }

    public function run()
    {

        return MetisMenu::widget(['items' => $this->items]);
    }

} 