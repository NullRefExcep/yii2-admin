<?php

namespace nullref\admin\controllers;

use nullref\admin\models\LoginForm;
use yii\base\Controller;

/**
 *
 */
class MainController extends Controller
{
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
        }
        return $this->render('login', ['model' => $model]);
    }
}

