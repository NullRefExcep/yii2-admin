<?php

namespace nullref\admin\components;

use yii\web\User as BaseUser;
use Yii;
/**
 * @author    Dmytro Karpovych
 * @copyright 2015 NRE
 */
class User extends BaseUser
{
    protected function getAuthManager()
    {
        return Yii::$app->getModule('admin')->get('authManager',false);
    }
}