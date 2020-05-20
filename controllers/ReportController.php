<?php

namespace app\controllers;

use app\models\Activity;
use app\models\Employee;
use app\models\EmployeeActivity;
use app\models\Job;
use app\models\Notification;
use app\models\Timesheet;
use DateTime;
use DOMDocument;
use Yii;
use yii\helpers\Json;
use yii\web\ForbiddenHttpException;

class ReportController extends InController
{

    private function getYearDays($year = '2020')
    {
        $year = date('Y');
        $path = Yii::getAlias('@webroot/calendars/calendar.csv');

        $months = array();
        if (($handle = fopen($path, 'r')) !== false) {
            $i = 0;
            while (($row = fgetcsv($handle, 1000)) !== false) {
                // $data[] = iconv('utf-8', 'windows-1251', $row);
                if ($row[0] == $year) {
                    foreach ($row as $i => $item) {
                        if ($i > 0 && $i < 13) {
                            $months[] = $item;
                        }
                    }
                }
            }
            fclose($handle);
        }

        // $month_days = [];
        $year_days = [];
        foreach ($months as $no => $month) {
            $month_days_r = explode(',', $month);
            foreach ($month_days_r as $d) {
                // $month_days[$no][] = trim($d, '+ *');
                $year_days[] = ($no + 1) . '.' . trim($d, '+ *');
            }
        }
        return $year_days;
    }

    public function beforeAction($action)
    {
        // var_dump(Yii::$app->user->identity);die;
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/site/login');
        }
        $user_role = Yii::$app->user->identity->role;
        if ($user_role == 1) {
            throw new ForbiddenHttpException('Недостаточно прав для выполнения операции');
        }

        return parent::beforeAction($action);
    }
    public function actionIndex($year = 2020)
    {
        $year_days = $this->getYearDays();

        return $this->render('index', compact('year_days'));
    }

    public function actionManagerActivity()
    {
        $activities = Activity::find()
            ->where(['manager_id' => Yii::$app->user->identity->id])
            ->andWhere(['!=', 'activity_type_id', 1])
            ->all();
        return $this->render('manager-activity', compact('activities'));
    }
    public function actionManagerActivityResult($begin, $end, $activity_id, $with_details)
    {
        $this->layout = 'empty';
        $employee_ids = EmployeeActivity::find()
            ->where(['activity_id' => $activity_id])
            ->select(['employee_id'])
            ->column();
        $job_ids = Job::find()
            ->where(['activity_id' => $activity_id])
            ->select(['id'])
            ->column();
        $sum = 0;
        $employees = [];
        $jobs = [];

        if ($with_details == 0) {
            $employees = Employee::find()
                ->where(['in', 'id', $employee_ids])
                ->asArray()
                ->all();

            $sum = 0;
            foreach ($employees as $no => $employee) {
                $employees[$no]['time_quantity'] = Timesheet::find()
                    ->where(['between', 'date', $begin, $end])
                    ->andWhere(['in', 'job_id', $job_ids])
                    ->andWhere(['employee_id' => $employee['id']])
                    ->sum('quantity');
                $sum += $employees[$no]['time_quantity'];
            }
        }

        if ($with_details == 1) {
            $jobs = Job::find()
                ->where(['in', 'id', $job_ids])
                ->asArray()
                ->all();

            $sum = 0;

            foreach ($jobs as $no => $job) {
                $jobs[$no]['time_quantity'] = Timesheet::find()
                    ->where(['between', 'date', $begin, $end])
                    ->andWhere(['in', 'employee_id', $employee_ids])
                    ->andWhere(['job_id' => $job['id']])
                    ->sum('quantity');
                $sum += $jobs[$no]['time_quantity'];
            }
        }
        return $this->render('manager-activity-result', compact('with_details', 'sum', 'employees', 'jobs'));
    }

    public function actionResourceManager()
    {
        return $this->render('resource-manager');
    }

    public function actionResourceManagerResult($begin, $end, $balance)
    {
        $this->layout = 'empty';
        $disbalance_count = 0;
        $employee_ids = Employee::find()
            ->where(['manager_id' => Yii::$app->user->identity->id])
            ->select(['id'])
            ->column();
        $employees = Employee::find()
            ->where(['in', 'id', $employee_ids])
            ->asArray()
            ->all();

        $sum = 0;
        $d1 = new DateTime(date("Y-m-d H:i:s", strtotime($begin)));
        $d2 = new DateTime(date("Y-m-d H:i:s", strtotime($end)));
        $diff = $d1->diff($d2)->days + 1;

        foreach ($employees as $no => $employee) {
            $employees[$no]['time_quantity'] = Timesheet::find()
                ->where(['between', 'date', $begin, $end])
                ->andWhere(['employee_id' => $employee['id']])
                ->sum('quantity');
            $employees[$no]['workdays'] = $diff;
            if ($balance == 0) {
                $sum += $employees[$no]['time_quantity'];
            } else if ($balance == 1) {
                $sum += $employee['timenorm'] * $employees[$no]['workdays'] - $employees[$no]['time_quantity'] > 0 ? $employees[$no]['time_quantity'] : 0;
                $disbalance_count += ($employee['timenorm'] * $employees[$no]['workdays'] - $employees[$no]['time_quantity'] > 0) * 1;
            } else if ($balance == 2) {
                $sum += $employee['timenorm'] * $employees[$no]['workdays'] - $employees[$no]['time_quantity'] < 0 ? $employees[$no]['time_quantity'] : 0;
            }
        }
        return $this->render('resource-manager-result', compact('employees', 'sum', 'balance', 'disbalance_count'));
    }

    public function actionResource()
    {
        return $this->render('resource');
    }

    public function actionResourceResult($begin, $end, $disbalance)
    {
        $this->layout = 'empty';
        $id = Yii::$app->user->identity->id;
        $employee = Employee::findOne($id);

        $sum = 0;
        $disbalance_sum = 0;

        // $xml_data = simplexml_load_file(Yii::getAlias('@webroot/calendars/calendar2020.xml'));
        // $holidays = [];
        // $json = json_encode($xml_data);
        // $array = json_decode($json, TRUE);
        // foreach ($array['days']['day'] as $day) {
        //     $holidays[] = $day['@attributes']['d'];
        // }

        $holidays = $this->getYearDays();

        $d1 = new DateTime(date("Y-m-d H:i:s", strtotime($begin)));
        $d2 = new DateTime(date("Y-m-d H:i:s", strtotime($end)));
        $workdays = $d1->diff($d2)->days + 1;
        $days = [];
        for ($i = 0; $i < $workdays; $i++) {
            $days[$i]['date'] = mktime(0, 0, 0, date('m', strtotime($begin)), date('d', strtotime($begin)) + $i, date('Y', strtotime($begin)));
            $md_date = date('n.j', $days[$i]['date']);
            $norm = in_array($md_date, $holidays) ? 0 : $employee->timenorm;
            $days[$i]['norm'] = $norm;
            $days[$i]['time_quantity'] = Timesheet::find()
                ->where(['employee_id' => $employee->id, 'date' => date('Y-m-d', $days[$i]['date'])])
                ->sum('quantity');
            if ($disbalance == 0) {
                $sum += $days[$i]['time_quantity'];
            } else {
                $sum += $days[$i]['time_quantity'] - $norm != 0 ? $days[$i]['time_quantity'] : 0;
            }
            $disbalance_sum += $norm - $days[$i]['time_quantity'];
        }

        return $this->render('resource-result', compact('employee', 'days', 'disbalance', 'sum', 'disbalance_sum', 'holidays'));
    }

    public function actionSendMessages()
    {
        $ids = Yii::$app->request->post('ids');
        $res = true;
        foreach ($ids as $id) {
            $not = new Notification();
            $not->employee_id = $id;
            $not->is_read = 0;
            $res * $not->save();
        }
        return Json::encode($res);
    }

    public function actionReadMessage()
    {
        return Json::encode(Yii::$app->db->createCommand()->update('notification', ['is_read' => 1], 'employee_id = ' . Yii::$app->user->identity->id)->execute());
    }
}
