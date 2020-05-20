<?php

namespace app\models;

class User extends \yii\base\BaseObject implements \yii\web\IdentityInterface
{
    public $id;
    public $login;
    public $role;
    public $first_name;
    public $last_name;
    // public $authKey;
    // public $accessToken;


    /**
     * {@inheritdoc}
     */
    public function __construct(Employee $employee)
    {
        $this->id = $employee->id;
        $this->login = $employee->login;
        $this->role = $employee->role_id;
        $this->first_name = $employee->first_name;
        $this->last_name = $employee->last_name;
    }

    public static function findIdentity($id)
    {
        $employee = Employee::findOne($id);
        return $employee ? new User($employee) : null;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // foreach (self::$users as $user) {
        //     if ($user['accessToken'] === $token) {
        //         return new static($user);
        //     }
        // }

        return true;
    }

    /**
     * Finds user by login
     *
     * @param string $login
     * @return Employee|null
     */
    public static function findBylogin($login)
    {

        // foreach (self::$users as $user) {
        //     if (strcasecmp($user['login'], $login) === 0) {
        //         return new static($user);
        //     }
        // }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }
}
