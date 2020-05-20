<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "employee".
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string|null $email
 * @property string|null $no
 * @property int $position_id
 * @property int $is_active
 * @property int $department_id
 * @property int|null $manager_id
 * @property float|null $timenorm
 * @property int $role_id
 * @property string $login
 * @property string $password_hash
 *
 * @property Activity[] $activities
 * @property Department $department
 * @property Position $position
 * @property Role $role
 * @property EmployeeActivity[] $employeeActivities
 * @property Activity[] $activities0
 * @property Timesheet[] $timesheets
 */
class Employee extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employee';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'position_id', 'department_id', 'role_id', 'login', 'password_hash'], 'required'],
            [['position_id', 'is_active', 'department_id', 'manager_id', 'role_id'], 'integer'],
            [['timenorm'], 'number'],
            [['password_hash'], 'string'],
            [['first_name', 'last_name', 'login'], 'string', 'max' => 45],
            [['email'], 'string', 'max' => 100],
            [['no'], 'string', 'max' => 20],
            [['department_id'], 'exist', 'skipOnError' => true, 'targetClass' => Department::className(), 'targetAttribute' => ['department_id' => 'id']],
            [['position_id'], 'exist', 'skipOnError' => true, 'targetClass' => Position::className(), 'targetAttribute' => ['position_id' => 'id']],
            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => Role::className(), 'targetAttribute' => ['role_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'Имя',
            'last_name' => 'Фамилия',
            'email' => 'E-mail',
            'no' => 'Табельный номер',
            'position_id' => 'Должность',
            'is_active' => 'Активный',
            'department_id' => 'Департамент',
            'manager_id' => 'Менеджер',
            'timenorm' => 'Норма времени',
            'role_id' => 'Роль',
            'login' => 'Логин',
            'password_hash' => 'Password Hash',
        ];
    }

    /**
     * Gets query for [[Activities]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getActivities()
    {
        return $this->hasMany(Activity::className(), ['manager_id' => 'id']);
    }


    /**
     * Gets query for [[Department]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDepartment()
    {
        return $this->hasOne(Department::className(), ['id' => 'department_id']);
    }

    /**
     * Gets query for [[Position]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPosition()
    {
        return $this->hasOne(Position::className(), ['id' => 'position_id']);
    }

    /**
     * Gets query for [[Role]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(Role::className(), ['id' => 'role_id']);
    }

    /**
     * Gets query for [[EmployeeActivities]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeActivities()
    {
        return $this->hasMany(EmployeeActivity::className(), ['employee_id' => 'id']);
    }

    /**
     * Gets query for [[Activities0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getActivities0()
    {
        return $this->hasMany(Activity::className(), ['id' => 'activity_id'])->viaTable('employee_activity', ['employee_id' => 'id']);
    }

    /**
     * Gets query for [[Timesheets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTimesheets()
    {
        return $this->hasMany(Timesheet::className(), ['employee_id' => 'id']);
    }
}
