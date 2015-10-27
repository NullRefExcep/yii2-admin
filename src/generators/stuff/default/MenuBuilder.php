<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2015 NRE
 */
echo "<?php\n";
?>
namespace app\components;

use nullref\admin\components\MenuBuilder as BaseBuilder;


class MenuBuilder extends BaseBuilder
{
    /**
    * @param array $items
    * @return array
    */
    public function build($items)
    {
        //@TODO customize menu items
        return $items;
    }
}

