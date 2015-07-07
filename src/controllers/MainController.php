<?php

namespace nullref\admin\controllers;

use nullref\admin\components\AdminController;
use nullref\admin\models\LoginForm;
use Yii;
use yii\filters\AccessControl;

/**
 *
 */
class MainController extends AdminController
{
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::className(),
                'user' => 'admin',
                'only' => ['logout', 'login', 'index', 'error'],
                'rules' => [
                    [
                        'actions' => ['error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['login'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['index', 'logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ]);
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        $this->layout = 'base';

        $model = new LoginForm();

        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            $model->login();
            return $this->redirect(['index']);
        }
        return $this->render('login', ['model' => $model]);
    }

    public function actionLogout()
    {
        Yii::$app->get('admin')->logout();

        return $this->goHome();
    }
}

