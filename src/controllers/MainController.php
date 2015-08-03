<?php

namespace nullref\admin\controllers;

use nullref\admin\components\AdminController;
use nullref\admin\models\Admin;
use nullref\admin\models\LoginForm;
use nullref\admin\models\PasswordResetForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\web\Response;

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
                        'roles' => ['?', '@'],
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

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
    public function actionLogin()
    {
        $this->layout = 'base';

        $model = new LoginForm();

        if (!Yii::$app->get('admin')->isGuest) {
            return $this->redirect(['/admin/main']);
        }

        if ($model->load(\Yii::$app->request->post())) {
            if ($model->validate()) {
                $model->login();
                return $this->redirect(['index']);
            } else {
                if (Yii::$app->request->isAjax) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return $model->errors;
                }
            }
        }
        return $this->render('login', ['model' => $model]);
    }

    public function actionLogout()
    {
        Yii::$app->get('admin')->logout();

        return $this->goHome();
    }

    public function actionReset($id, $token = false)
    {
        /** @var Admin $user */
        $user = Admin::findOne($id);
        if (($token !== false) && (isset($user)) && ($user->passwordResetToken === $token) && ($user->passwordResetExpire >= time())) {
            $model = new PasswordResetForm();
            if ($model->load(Yii::$app->getRequest()->post()) && $model->changePassword($user)) {
                Yii::$app->user->login($user);
                return $this->redirect(['index']);
            }
            return $this->render('password-reset', [
                'model' => $model,
            ]);
        }
        throw new NotFoundHttpException();
    }
}

