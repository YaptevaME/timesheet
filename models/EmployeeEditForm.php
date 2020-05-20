<?php

namespace app\models;

use Yii;
use yii\base\Model;


class EmployeeEditForm extends Model
{
    public $id;
    public $first_name;
    public $last_name;
    public $email;
    public $no;
    public $position_id;
    public $is_active;
    public $department_id;
    public $manager_id;
    public $timenorm;
    public $role_id;
    public $login;
    public $password;
    public $confirm_password;

    public function __construct($id)
    {
        $employee = Employee::findOne($id);
        $this->id = $employee->id;
        $this->first_name = $employee->first_name;
        $this->last_name = $employee->last_name;
        $this->email = $employee->email;
        $this->no = $employee->no;
        $this->position_id = $employee->position_id;
        $this->is_active = $employee->is_active;
        $this->department_id = $employee->department_id;
        $this->manager_id = $employee->manager_id;
        $this->timenorm = $employee->timenorm;
        $this->role_id = $employee->role_id;
        $this->login = $employee->login;
    }

    public function rules()
    {
        return [
            [['first_name', 'last_name', 'position_id', 'department_id', 'role_id', 'login'], 'required'],
            [['position_id', 'is_active', 'department_id', 'manager_id', 'role_id'], 'integer'],
            [['timenorm'], 'number'],
            [['password', 'confirm_password'], 'string'],
            [['first_name', 'last_name', 'login'], 'string', 'max' => 45],
            [['email'], 'string', 'max' => 100],
            [['no'], 'string', 'max' => 20],
            [['department_id'], 'exist', 'skipOnError' => true, 'targetClass' => Department::className(), 'targetAttribute' => ['department_id' => 'id']],
            [['position_id'], 'exist', 'skipOnError' => true, 'targetClass' => Position::className(), 'targetAttribute' => ['position_id' => 'id']],
            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => Role::className(), 'targetAttribute' => ['role_id' => 'id']],

        ];
    }

    public function attributeLabels()
    {
        return [
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
            'password' => 'Пароль',
            'confirm_password' => 'Подтверждение пароля',
        ];
    }

    public function save($id)
    {
        $employee = Employee::findOne($id);
        $errors = [];
        if ($employee_found = Employee::find()->where(['login' => $this->login])->andWhere(['!=', 'id', $id])->one()) {
            $errors[] = 'Пользователь с логином <code> ' . $employee_found->login . ' </code> существует.';
        }

        if ($this->password !== $this->confirm_password) {
            $errors[] = 'Введенные пароли не совпадают.';
        }

        if (count($errors) === 0) {
            $employee->first_name = $this->first_name;
            $employee->last_name = $this->last_name;
            $employee->email = $this->email;
            $employee->no = $this->no;
            $employee->position_id = $this->position_id;
            $employee->is_active = $this->is_active;
            $employee->department_id = $this->department_id;
            $employee->manager_id = $this->manager_id;
            $employee->timenorm = $this->timenorm;
            $employee->role_id = $this->role_id;
            $employee->login = $this->login;
            if ($this->password != '') {
                $employee->password_hash = Yii::$app->security->generatePasswordHash($this->password);
            }
            if ($employee->save()) {
                $this->id = $employee->id;
                return true;
            } else {
                $errors[] = 'Не удалось сохранить';
            }
        }
        return $errors;
    }
}
