<?php

namespace nullref\admin\controllers;

use nullref\admin\components\AccessControl;
use nullref\admin\components\AdminController;
use nullref\admin\models\Admin;
use nullref\admin\models\LoginForm;
use nullref\admin\models\PasswordResetForm;
use nullref\admin\traits\HasModule;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 *
 */
class MainController extends AdminController
{
    use HasModule;

    public $dashboardPage = ['/admin'];

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::className(),
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
                'class' => 'nullref\admin\actions\ErrorAction',
            ],
        ];
    }

    /**
     * @return array|string|Response
     * @throws \yii\base\InvalidConfigException
     */
    public function actionLogin()
    {
        $this->layout = 'base';

        $model = new LoginForm();

        /** @var yii\web\User $adminComponent */
        $admin = Yii::$app->get($this->getModule()->adminComponent);

        if (!$admin->isGuest) {
            return $this->redirect($this->dashboardPage);
        }

        if ($model->load(\Yii::$app->request->post())) {
            if ($model->validate()) {
                $model->login();
                return $this->redirect(Yii::$app->request->referrer ?? $admin->getReturnUrl($this->dashboardPage));
            }
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return $model->errors;
            }
        }
        return $this->render('login', ['model' => $model]);
    }

    /**
     * @return Response
     * @throws \yii\base\InvalidConfigException
     */
    public function actionLogout()
    {
        /** @var yii\web\User $adminComponent */
        $admin = Yii::$app->get($this->getModule()->adminComponent);
        $admin->logout();

        return $this->goHome();
    }

    /**
     * @param $id
     * @param bool $token
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionReset($id, $token = false)
    {
        $module = $this->getModule();

        /** @var yii\web\User $adminComponent */
        $admin = Yii::$app->get($module->adminComponent);

        //@TODO move user finding and checking logic to model
        /** @var Admin $user */
        $user = call_user_func(array($module->adminModel, 'findOne'), [$id]);

        if (($token !== false) && (isset($user)) && ($user->passwordResetToken === $token) && ($user->passwordResetExpire >= time())) {
            $model = new PasswordResetForm();
            if ($model->load(Yii::$app->getRequest()->post()) && $model->changePassword($user)) {
                $admin->login($user);
                return $this->redirect(['index']);
            }
            return $this->render('password-reset', [
                'model' => $model,
            ]);
        }
        throw new NotFoundHttpException();
    }
}

