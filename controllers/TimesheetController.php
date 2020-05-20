<?php

namespace app\controllers;

use app\models\Job;
use app\models\Notification;
use Yii;
use app\models\Timesheet;
use yii\helpers\Json;
use yii\web\ForbiddenHttpException;

/**
 * TimesheetController implements the CRUD actions for Timesheet model.
 */
class TimesheetController extends InController
{
    public function beforeAction($action)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/site/login');
        }
        $user_role = Yii::$app->user->identity->role;
        if ($user_role != 4) {
            throw new ForbiddenHttpException('Недостаточно прав для выполнения операции');
        }

        return parent::beforeAction($action);
    }

    
    public function actionList()
    {
        $notifications = Notification::find()
            ->where(['employee_id' => Yii::$app->user->identity->id, 'is_read' => 0])
            ->all();
        $first_year_day = date('w', mktime(0, 0, 0, 1, 1, date('Y'))) * 1;
        $current_week = strftime("%W") * 1;
        if ($first_year_day !== 1) {
            $current_week++;
        }
        $jobs = Job::find()->all();
        return $this->render('list', compact('current_week', 'first_year_day', 'jobs', 'notifications'));
    }

    public function actionAddJob()
    {
        $this->layout = 'empty';
        $query =
            'SELECT DISTINCT j.id, j.name, a.name AS "activity_name"
            FROM employee_activity AS ea
                JOIN employee AS e ON e.id = ea.employee_id
                JOIN activity AS a ON a.id = ea.activity_id OR a.activity_type_id = 1
                JOIN job AS j ON j.activity_id = a.id
            WHERE e.id = 1 AND a.status_id = 2 AND j.status_id = 2';

        $jobs = Yii::$app->db->createCommand($query)
            ->bindValue(':employee_id', Yii::$app->user->identity->id)
            ->queryAll();

        return $this->render('add-job', compact('jobs'));
    }

    public function actionWeekDays($year, $week)
    {
        $this->layout = 'empty';
        $employee_id = Yii::$app->user->identity->id;

        $weekday_names = [
            0 => 'Вс',
            1 => 'Пн',
            2 => 'Вт',
            3 => 'Ср',
            4 => 'Чт',
            5 => 'Пт',
            6 => 'Сб',
        ];

        $first_year_day = date('w', mktime(0, 0, 0, 1, 1, $year)) * 1;
        $weekdays = [];
        if ($first_year_day === 1) {
            for ($i = 0; $i < 7; $i++) {
                $weekdays[] = mktime(0, 0, 0, 1, ($week - 1) * 7 + 1 + $i, $year);
            }
            $monday_date = mktime(0, 0, 0, 1, ($week - 1) * 7 + 1, $year);
            $sunday_date = mktime(0, 0, 0, 1, ($week - 1) * 7 + 7, $year);
        } else {
            $plus_days = $first_year_day == 0 ? 1 : 9 - $first_year_day;
            for ($i = 0; $i < 7; $i++) {
                $weekdays[] = mktime(0, 0, 0, 1, ($week - 2) * 7 + $plus_days + $i, $year);
            }
            $monday_date = mktime(0, 0, 0, 1, ($week - 2) * 7 + $plus_days, $year);
            $sunday_date = mktime(0, 0, 0, 1, ($week - 2) * 7 + $plus_days + 6, $year);
        }

        $job_ids = Timesheet::find()
            ->where(
                [
                    'employee_id' => Yii::$app->user->identity->id
                ]
            )
            ->andWhere(['between', 'date', date('Y-m-d', $monday_date), date('Y-m-d', $sunday_date)])
            ->distinct()
            ->select(['job_id'])
            ->column();
        $jobs = Job::find()
            ->where(['in', 'id', $job_ids])
            ->asArray()
            ->all();
        foreach ($jobs as $no => $job) {
            foreach ($weekdays as $weekday) {
                $jobs[$no]['weekdays'][] = [
                    'date' => $weekday,
                    'tsh' => Timesheet::findOne([
                        'employee_id' => Yii::$app->user->identity->id,
                        'job_id' => $job['id'],
                        'date' => date('Y-m-d', $weekday)
                    ])
                ];
            }
        }
        return $this->render('week-days', compact('monday_date', 'sunday_date', 'weekdays', 'jobs', 'weekday_names'));
    }

    public function actionJobRow($year, $week, $job_id)
    {
        $this->layout = 'empty';
        $first_year_day = date('w', mktime(0, 0, 0, 1, 1, $year)) * 1;
        $weekdays = [];
        if ($first_year_day === 1) {
            for ($i = 0; $i < 7; $i++) {
                $weekdays[] = mktime(0, 0, 0, 1, ($week - 1) * 7 + 1 + $i, $year);
            }
        } else {
            $plus_days = $first_year_day == 0 ? 1 : 9 - $first_year_day;
            for ($i = 0; $i < 7; $i++) {
                $weekdays[] = mktime(0, 0, 0, 1, ($week - 2) * 7 + $plus_days + $i, $year);
            }
        }
        $job = Job::findOne($job_id);
        return $this->render('job-row', compact('weekdays', 'job'));
    }

    public function actionCreateTimesheets()
    {
        $timesheets = Yii::$app->request->post('timesheets');
        $job_id = Yii::$app->request->post('jobId');
        $employee_id = Yii::$app->user->identity->id;
        $result = true;
        foreach ($timesheets as $tsh) {
            // $model = $tsh[2] == 0 ? new Timesheet() : Timesheet::findOne($tsh[2]);
            $model = Timesheet::findOne([
                'employee_id' => Yii::$app->user->identity->id,
                'job_id' => $job_id,
                'date' => $tsh[0],
            ]);
            if ($model == null) {
                $model = new Timesheet();
            }
            $model->employee_id = $employee_id;
            $model->job_id = $job_id;
            $model->date = $tsh[0];
            $model->quantity = $tsh[1] * 1;
            $result *= $model->save();
        }
        return Json::encode($result);
    }
}
