<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2015 NRE
 */

namespace nullref\admin\components;


use nullref\admin\interfaces\IMenuBuilder;

abstract class MenuBuilder implements IMenuBuilder
{
    public function filterByRole($menu, $role, $paramName = 'roles')
    {
        if ($role === null) {
            return [];
        }
        $result = [];

        foreach ($menu as $key => $item) {

            if (isset($item[$paramName])) {
                if (in_array($role, $item[$paramName])) {
                    $result[$key] = $item;
                }
            } else {
                $result[$key] = $item;
            }
        }

        //@TODO implement filtering items with $role in $paramName value
        /**e.g:
         * input:
         *  $menu:
         *  ['label' => 'Catalog', 'icon' => 'archive', 'items' => [
         *  'vendor' => ['label' => 'Vendors', 'icon' => 'archive', 'url' => ['/vendor/admin'], roles=>[1]],
         *  'tag' => ['label' => 'Tags', 'icon' => 'archive', 'url' => ['/tag/admin'],'roles'=>[1,2]],
         *  ]]
         *  $role:
         *  2
         *
         * output:
         *  ['label' => 'Catalog', 'icon' => 'archive', 'items' => [
         *  'tag' => ['label' => 'Tags', 'icon' => 'archive', 'url' => ['/tag/admin'],'roles'=>[1,2]],
         *  ]]
         */
        return $result;
    }
} 