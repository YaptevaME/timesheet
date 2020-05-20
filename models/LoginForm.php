<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{
    public $login;
    public $password;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // login and password are both required
            [['login', 'password'], 'required'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'login' => 'Логин',
            'password' => 'Пароль',
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getEmployee();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect login or password.');
            }
        }
    }

    public function login(Employee $employee)
    {
        $user = new User($employee);
        Yii::$app->user->login($user);
    }

    /**
     * Finds user by [[login]]
     *
     * @return User|null
     */
    public function getEmployee()
    {
        if ($this->_user === false) {
            $this->_user = Employee::findOne(['login' => $this->login]);
        }

        return $this->_user;
    }
}
