<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

class InController extends Controller
{
    // public function beforeAction($action)
    // {
    //     // var_dump(Yii::$app->user->identity);die;
    //     if (Yii::$app->user->isGuest) {
    //         return $this->redirect('/site/login');
    //     }
    //     $user_role = Yii::$app->user->identity->role;
    //     // if ($user_role != 1) {
    //     //     throw new ForbiddenHttpException('Недостаточно прав для выполнения операции');
    //     // }

    //     return parent::beforeAction($action);
    // }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        // 'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
}
