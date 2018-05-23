<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2018 NRE
 */


namespace nullref\admin\traits;


trait HasModule
{
    /**
     * @return \nullref\admin\Module
     */
    public function getModule()
    {
        return Yii::$app->getModule('admin');
    }

}