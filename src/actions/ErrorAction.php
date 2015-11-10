<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2015 NRE
 */

namespace nullref\admin\actions;

use nullref\admin\Module;
use Yii;
use yii\web\ErrorAction as BaseErrorAction;
use yii\web\IdentityInterface;
use yii\web\User;

class ErrorAction extends BaseErrorAction
{
    /**
     * @return bool
     */
    protected function beforeRun()
    {
        /** @var Module $module */
        $module = Yii::$app->getModule('admin');

        /** @var User $user */
        $user = Yii::$app->get($module->adminComponent);

        if ($user->isGuest) {
            $this->controller->layout = '@nullref/admin/views/layouts/error';
        }
        return parent::beforeRun();
    }


}