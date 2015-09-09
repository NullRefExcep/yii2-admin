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

        return $result;
    }
} 