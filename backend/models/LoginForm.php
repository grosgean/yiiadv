<?php
namespace backend\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $adminname;
    public $password;
    public $rememberMe = true;

    private $_admin = false;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // adminname and password are both required
            [['adminname', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     */
    public function validatePassword()
    {
        if (!$this->hasErrors()) {
            $admin = $this->getAdmin();
            if (!$admin || !$admin->validatePassword($this->password)) {
                $this->addError('password', 'Incorrect adminname or password.');
            }
        }
    }

    /**
     * Logs in a admin using the provided adminname and password.
     *
     * @return boolean whether the admin is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getAdmin(), $this->rememberMe ? 3600 * 24 * 30 : 0);
            //return Yii::$app->user->login(Yii::$app->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }

    /**
     * Finds admin by [[adminname]]
     *
     * @return Admin|null
     */
    public function getAdmin()
    {
        if ($this->_admin === false) {
            $this->_admin = Admin::findByUsername($this->adminname);
        }

        return $this->_admin;
    }
}
