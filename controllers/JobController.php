<?php

namespace app\controllers;

use Yii;
use app\models\Job;
use app\models\JobSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;

/**
 * JobController implements the CRUD actions for Job model.
 */
class JobController extends InController
{
    public function beforeAction($action)
    {
        // var_dump(Yii::$app->user->identity);die;
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/site/login');
        }
        $user_role = Yii::$app->user->identity->role;
        if ($user_role != 1 && $user_role != 2) {
            throw new ForbiddenHttpException('Недостаточно прав для выполнения операции');
        }

        return parent::beforeAction($action);
    }

    /**
     * Lists all Job models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new JobSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Job model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        if ($model->activity->manager_id != Yii::$app->user->identity->id && Yii::$app->user->identity->role != 1) {
            throw new ForbiddenHttpException('Недостаточно прав для выполнения операции');
        }
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Job model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($activity_id = null)
    {
        $model = new Job();
        if ($activity_id) {
            $model->activity_id = $activity_id;
        }
        $model->status_id = 2;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Job model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->activity->manager_id != Yii::$app->user->identity->id && Yii::$app->user->identity->role != 1) {
            throw new ForbiddenHttpException('Недостаточно прав для выполнения операции');
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Job model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model->activity->manager_id != Yii::$app->user->identity->id && Yii::$app->user->identity->role != 1) {
            throw new ForbiddenHttpException('Недостаточно прав для выполнения операции');
        }
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Job model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Job the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Job::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
