<?php

namespace app\controllers;

use Yii;
use app\models\Activity;
use app\models\ActivitySearch;
use app\models\Employee;
use app\models\EmployeeActivity;
use app\models\Job;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

/**
 * ActivityController implements the CRUD actions for Activity model.
 */
class ActivityController extends InController
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
     * Lists all Activity models.
     * @return mixed
     */
    public function actionIndex()
    {
        $activities = Activity::find();
        if (Yii::$app->user->identity->role != 1) {
            $activities = $activities->where(['manager_id' => Yii::$app->user->identity->id]);
        }
        $activities = $activities->all();

        return $this->render('index', compact('activities'));

        // $searchModel = new ActivitySearch();
        // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // return $this->render('index', [
        //     'searchModel' => $searchModel,
        //     'dataProvider' => $dataProvider,
        // ]);
    }

    /**
     * Displays a single Activity model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        if ($model->manager_id != Yii::$app->user->identity->id && Yii::$app->user->identity->role != 1) {
            throw new ForbiddenHttpException('Недостаточно прав для выполнения операции');
        }
        $jobs = Job::find()
            ->where(['activity_id' => $id, 'status_id' => 2])
            ->all();
        $employee_ids = EmployeeActivity::find()
            ->where(['activity_id' => $id])
            ->select(['employee_id'])
            ->column();
        $employees = Employee::findAll($employee_ids);
        return $this->render('view', compact('model', 'jobs', 'employees'));
    }

    public function actionAddEmployee($activity_id)
    {
        $this->layout = 'empty';
        $model = new EmployeeActivity();
        $model->activity_id = $activity_id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $activity_id]);
        }
        return $this->render('add-employee', compact('model'));
    }

    /**
     * Creates a new Activity model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Activity();
        $model->manager_id = Yii::$app->user->identity->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Activity model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->manager_id != Yii::$app->user->identity->id && Yii::$app->user->identity->role != 1) {
            throw new ForbiddenHttpException('Недостаточно прав для выполнения операции');
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if ($model->status_id == 3 || $model->status_id == 1) {
                Yii::$app->db->createCommand()->update('job', ['status_id' => $model->status_id], 'activity_id = ' . $model->id)->execute();
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Activity model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model->manager_id != Yii::$app->user->identity->id && Yii::$app->user->identity->role != 1) {
            throw new ForbiddenHttpException('Недостаточно прав для выполнения операции');
        }
        $model->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Activity model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Activity the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Activity::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
