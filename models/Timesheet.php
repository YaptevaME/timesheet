<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "timesheet".
 *
 * @property int $id
 * @property int $employee_id
 * @property int $job_id
 * @property string $date
 * @property float $quantity
 *
 * @property Employee $employee
 * @property Job $job
 */
class Timesheet extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'timesheet';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['employee_id', 'job_id', 'date', 'quantity'], 'required'],
            [['employee_id', 'job_id'], 'integer'],
            [['date'], 'safe'],
            [['quantity'], 'number'],
            [['employee_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employee::className(), 'targetAttribute' => ['employee_id' => 'id']],
            [['job_id'], 'exist', 'skipOnError' => true, 'targetClass' => Job::className(), 'targetAttribute' => ['job_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'employee_id' => 'Employee ID',
            'job_id' => 'Job ID',
            'date' => 'Date',
            'quantity' => 'Quantity',
        ];
    }

    /**
     * Gets query for [[Employee]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmployee()
    {
        return $this->hasOne(Employee::className(), ['id' => 'employee_id']);
    }

    /**
     * Gets query for [[Job]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJob()
    {
        return $this->hasOne(Job::className(), ['id' => 'job_id']);
    }
}
