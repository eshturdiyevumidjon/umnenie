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
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user = false;
    public $social;
    public $user_id;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
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
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }

    public function getUserBySocial()
    {
        if ($this->_user === false) 
        {
            switch ($this->social) {
                case 1: $this->_user = User::findBySocial('instagram_user_id', $this->user_id);
                case 2: $this->_user = User::findBySocial('facebook_user_id', $this->user_id);
                case 3: $this->_user = User::findBySocial('vk_user_id', $this->user_id);
                case 4: $this->_user = User::findBySocial('google_account_user_id', $this->user_id);
                default: return "Неизвестно";
            }
        }

        return $this->_user;
    }

    public function loginWithSocialNetwork()
    {
        $user = $this->getUserBySocial();
        if($user->password == $this->password) return Yii::$app->user->login($this->_user, $this->rememberMe ? 3600*24*30 : 0);

        return false;
    }
}
