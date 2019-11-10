<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Class RegisterForm
 * @package app\models
 */
class RegisterForm extends Model
{
    const EVENT_REGISTERED = 'event_registered';

    public $fio;
    public $email;
    public $password;
    public $telephone;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fio', 'email', 'password'], 'required'],
            [['telephone'], 'string'],
            [['password', 'telegram'], 'string', 'max' => 255],
            [['email'], 'email'],
            [['agree'], 'integer'],
            [['email'], 'unique', 'targetClass' => '\app\models\User'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'fio' => 'ФИО',
            'email' => 'Логин',
            'password' => 'Пароль',
            'telephone' => 'Телефон',
        ];
    }

    public function validateAgree($attribute)
    { 
         $this->addError($attribute, 'Необходимо Ваше согласие');
    }

    /**
     * Регистрирует нового пользователя
     * @param int $type
     * @return Users|null
     */
    public function register($type = 1)
    {
        if($this->validate() === false){
            return null;
        }

        $user = new Users();
        $user->fio = $this->fio;
        $user->email = $this->email;
        $user->telephone = $this->telephone;
        $user->password = $this->password;
        $user->type = $type;

        if($user->save()) {
            return $user;
        }

        return null;
    }

}