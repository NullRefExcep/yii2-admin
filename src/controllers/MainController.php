<?php

namespace nullref\admin\controllers;

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
}

