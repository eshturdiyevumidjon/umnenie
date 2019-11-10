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
class NewPasswordForm extends Model
{
    public $password;
    public $old_password;
    public $retry_password;
    Const EXPIRE_TIME = 86400; //token expiration time, 1 days valid

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['retry_password', 'password', 'old_password'], 'required'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
            ['retry_password', 'validateRetryPassword'],
            ['old_password', 'validateOldPassword'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'password' => 'Новый пароль',
            'old_password' => 'Старый пароль',
            'retry_password' => 'Подтвердите новый пароль',
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    
    public function validateOldPassword($attribute, $params)
    {
        $user = User::findOne(\Yii::$app->user->identity->id);
        if(!$user->validatePassword($this->old_password)){
            $this->addError($attribute, '«Старый пароль» не правильно.');
            //$this->addError($attribute, '1');
        }
    }

    public function validatePassword($attribute, $params)
    {
        if ($this->password != $this->retry_password ) {
            $this->addError($attribute, '«Новый пароль» и «Подтвердите новый пароль» не совпадают, введите правильные пароли');
            //$this->addError($attribute, '2');
        }
    }

    public function validateRetryPassword($attribute, $params)
    {
        if ($this->password != $this->retry_password ) {
            $this->addError($attribute, '«Новый пароль» и «Повторить пароль» не совпадают, введите правильные пароли');
            //$this->addError($attribute, '3');
        }
    }

    public function setPassword(){
        $user = Users::findOne(\Yii::$app->user->identity->id);
        $user->password = Yii::$app->security->generatePasswordHash($this->password);
        $user->access_token = Yii::$app->getSecurity()->generateRandomString();
        $user->expire_at = time() + $this::EXPIRE_TIME;
        $user->save(false);
        return true;
    }
}
