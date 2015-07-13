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
    public $idParam = '__admin_id';
    public $authTimeoutParam = '__admin_expire';
    public $absoluteAuthTimeoutParam = '__admin_absoluteExpire';
    public $returnUrlParam = '__admin_returnUrl';

    protected function getAuthManager()
    {
        return Yii::$app->getModule('admin')->get('authManager',false);
    }
}