<?php

namespace app\controllers;

use Yii;
use app\models\Employee;
use app\models\EmployeeEditForm;
use app\models\EmployeeRegisterForm;
use app\models\EmployeeSearch;
use yii\web\NotFoundHttpException;

/**
 * EmployeeController implements the CRUD actions for Employee model.
 */
class EmployeeController extends AdminController
{
    /**
     * Lists all Employee models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EmployeeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Employee model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Employee model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $errors = [];
        $model = new EmployeeRegisterForm();

        if ($model->load(Yii::$app->request->post())) {
            $result = $model->save();
            if ($result === true) {
                return $this->redirect(['index']);
            } else {
                $errors = $result;
            }
        }
        $model->password = '';
        $model->confirm_password = '';
        return $this->render('create', compact('model', 'errors'));
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $errors = [];
        $model = new EmployeeEditForm($id);

        if ($model->load(Yii::$app->request->post())) {
            $result = $model->save($id);
            if ($result === true) {
                return $this->redirect(['index']);
            } else {
                $errors = $result;
            }
        }

        $model->password = '';
        $model->confirm_password = '';
        return $this->render('update', compact('model', 'errors'));
    }

    /**
     * Deletes an existing Employee model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Employee model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Employee the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Employee::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
