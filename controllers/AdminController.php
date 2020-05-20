<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

class AdminController extends InController
{
    public function beforeAction($action)
    {
        // var_dump(Yii::$app->user->identity);die;
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/site/login');
        }
        $user_role = Yii::$app->user->identity->role;
        if ($user_role != 1) {
            throw new ForbiddenHttpException('Недостаточно прав для выполнения операции');
        }

        return parent::beforeAction($action);
    }

}
