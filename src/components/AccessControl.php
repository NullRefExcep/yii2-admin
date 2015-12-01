<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2015 NRE
 */

namespace nullref\admin\components;

use nullref\admin\Module;
use Yii;
use yii\base\ActionFilter;
use yii\di\Instance;
use yii\filters\AccessControl as BaseAccessControl;


class AccessControl extends BaseAccessControl
{
    public $user = '';

    public function init()
    {
        /** @var $module Module */
        if (empty($this->user) && ($module = Yii::$app->getModule('admin')) != null) {
            $this->user = $module->adminComponent;
        }
        ActionFilter::init();
        if (empty($this->rules)) {
            $this->rules = [[
                'actions' => [],
                'allow' => true,
                'roles' => ['@'],
            ]];
        }

        $this->user = Instance::ensure($this->user, User::className());
        foreach ($this->rules as $i => $rule) {
            if (is_array($rule)) {
                $this->rules[$i] = Yii::createObject(array_merge($this->ruleConfig, $rule));
            }
        }
    }

}