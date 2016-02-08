<?php

namespace app\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\RegisterEmailForm;
use app\models\CreatePasswordForm;
use app\models\LoginForm;

class SiteController extends Controller
{

    public function actionIndex()
    {
        return $this->renderContent('Welcome! Use menu for select action. (here can be your advert)');
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'except' => ['error', 'index'],
                'rules' => [
                    [
                        'actions' => ['logout', 'user'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
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
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionUser()
    {
        $model = new UserForm();
        if ($model->load(Yii::$app->request->post()) && $model->update()) {
            return $this->goBack();
        }
        return $this->render('user', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionRegisterEmail()
    {
        $model = new RegisterEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->register()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Thank you for registration. Check your email for continue.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }
            return $this->goBack();
        }
        return $this->render('registerEmail', [
            'model' => $model,
        ]);
    }

    public function actionCreatePassword($token)
    {
        try {
            $model = new CreatePasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->createPassword()) {
            Yii::$app->session->setFlash('success', 'Password was created.');

            return $this->goHome();
        }

        return $this->render('createPassword', [
            'model' => $model,
        ]);
    }
}
