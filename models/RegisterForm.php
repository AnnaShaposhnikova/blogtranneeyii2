<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\Exception;
use yii\validators\EmailValidator;
use yii\validators\UniqueValidator;

/**
 * LoginForm is the model behind the login form.
 *
 * @property Users|null $user This property is read-only.
 *
 */
class RegisterForm extends Model
{
    public $first_name;
    public $last_name;
    public $email;
    public $password;
    public $rememberMe = true;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['first_name', 'last_name', 'email', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            ['email', EmailValidator::class],
            ['email', UniqueValidator::class, 'targetClass' => Users::class, 'targetAttribute' => 'email'],
            // password is validated by validatePa,ssword()
            ['password', 'string', 'min' => 8],

        ];
    }
    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function register()
    {
        if (!$this->validate()) {
            return false;
        }
        $user = new Users();

        $user->role = Users::USER_ROLE;
        $user->first_name = $this->first_name;
        $user->last_name = $this->last_name;
        $user->email = $this->email;
        $user->password = $user->passwordHash($this->password);
        if ($user->save()) {
            return Yii::$app->user->login($user,$this->rememberMe ? 3600*24*30 : 0);
        }
        throw new Exception(print_r($user->getFirstErrors(), true));
    }


}


