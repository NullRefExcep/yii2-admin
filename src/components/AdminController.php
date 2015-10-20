<?php

namespace nullref\admin\components;

use nullref\admin\Module;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Application;
use yii\web\Controller;

/**
 * @author    Dmytro Karpovych
 * @copyright 2015 NRE
 */
class AdminController extends Controller
{
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'user' => 'admin',
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ]);
    }

    public function init()
    {
        if (Yii::$app instanceof Application) {
            /** @var Module $module */
            $module = Yii::$app->getModule('admin');
            $this->layout = $module->layout;
            $this->module->setLayoutPath($module->getLayoutPath());
            Yii::$app->errorHandler->errorAction = '/admin/main/error';
        }
        parent::init();
    }

} 