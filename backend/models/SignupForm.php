<?php
namespace backend\models;

use backend\models\Admin;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $adminname;
    public $email;
    public $password;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['adminname', 'filter', 'filter' => 'trim'],
            ['adminname', 'required'],
            ['adminname', 'unique', 'targetClass' => '\backend\models\Admin', 'message' => 'This adminname has already been taken.'],
            ['adminname', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\backend\models\Admin', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 4],
        ];
    }

    /**
     * Signs Admin up.
     *
     * @return Admin|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $admin = new Admin();
            $admin->adminname = $this->adminname;
            $admin->email = $this->email;
            $admin->setPassword($this->password);
            $admin->generateAuthKey();
            $admin->save();
            return $admin;
        }

        return null;
    }
}
