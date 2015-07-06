<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2015 NRE
 */

namespace nullref\admin\components;


interface IMenuBuilder
{
    /**
     * @param array $items
     * @return array
     */
    public function build($items);
} 