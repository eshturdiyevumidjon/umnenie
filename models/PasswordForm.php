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
class PasswordForm extends Model
{
    public $password;
    public $new_password;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['new_password', 'password'], 'required'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
            ['new_password', 'validateNewPassword'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'password' => 'Новый пароль',
            'new_password' => 'Повторить пароль',
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
        if ($this->password != $this->new_password ) {
            $this->addError($attribute, '«Новый пароль» и «Повторить пароль» не совпадают, введите правильные пароли');
        }
    }

    public function validateNewPassword($attribute, $params)
    {
        if ($this->password != $this->new_password ) {
            $this->addError($attribute, '«Новый пароль» и «Повторить пароль» не совпадают, введите правильные пароли');
        }
    }
}
