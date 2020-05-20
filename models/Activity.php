<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "activity".
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property int $status_id
 * @property int $activity_type_id
 * @property int $manager_id
 *
 * @property Employee $manager
 * @property Status $status
 * @property ActivityType $activityType
 * @property EmployeeActivity[] $employeeActivities
 * @property Employee[] $employees
 * @property Job[] $jobs
 */
class Activity extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'activity';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'code', 'status_id', 'activity_type_id'], 'required'],
            [['status_id', 'activity_type_id', 'manager_id'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['code'], 'string', 'max' => 10],
            [['manager_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employee::className(), 'targetAttribute' => ['manager_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => Status::className(), 'targetAttribute' => ['status_id' => 'id']],
            [['activity_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ActivityType::className(), 'targetAttribute' => ['activity_type_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Наименование',
            'code' => 'Код',
            'status_id' => 'Статус',
            'activity_type_id' => 'Тип активности',
            'manager_id' => 'Менеджер',
        ];
    }

    /**
     * Gets query for [[Manager]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getManager()
    {
        return $this->hasOne(Employee::className(), ['id' => 'manager_id']);
    }

    /**
     * Gets query for [[Status]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Status::className(), ['id' => 'status_id']);
    }

    /**
     * Gets query for [[ActivityType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getActivityType()
    {
        return $this->hasOne(ActivityType::className(), ['id' => 'activity_type_id']);
    }

    /**
     * Gets query for [[EmployeeActivities]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeActivities()
    {
        return $this->hasMany(EmployeeActivity::className(), ['activity_id' => 'id']);
    }

    /**
     * Gets query for [[Employees]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmployees()
    {
        return $this->hasMany(Employee::className(), ['id' => 'employee_id'])->viaTable('employee_activity', ['activity_id' => 'id']);
    }

    /**
     * Gets query for [[Jobs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJobs()
    {
        return $this->hasMany(Job::className(), ['activity_id' => 'id']);
    }
}
