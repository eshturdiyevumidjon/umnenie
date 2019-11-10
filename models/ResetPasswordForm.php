<?php

namespace app\models;

use Yii;
use yii\base\Model;

class ResetPasswordForm extends Model
{
    public $email;

    /**
     * @return array
     */
    public function rules() 
    {
        return [
            [['email'], 'required'],
            [['email'], 'exist', 'targetClass' => '\app\models\User'],
        ];
    }
 
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email' => 'Email',
        ];
    }

    /**
     * @return Users|null
     */ 
    public function reset() 
    {
       if($this->validate())
       {
           /** @var \app\models\Users $user */
           $user = User::findByEmail($this->email);
           $newPassword = str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT);
           $user->password = Yii::$app->security->generatePasswordHash($newPassword);
           // $id = Yii::$app->security->generatePasswordHash($idd);
           // $user->password = $newPassword;

           try{
               Yii::$app->mailer->compose()
                   ->setFrom('alltender.uz@gmail.com')
                   ->setTo($user->email)
                   ->setSubject('Изменение пароля')
                   // ->setHtmlBody('Временный пароль для авторизации: '.$newPassword)
                   ->setHtmlBody('Чтобы получить доступ к системе, перейдите по ссылке ниже : http://'. $_SERVER['SERVER_NAME'] .'/site/password?token='.md5(md5($user->id)))
                   ->send();
           } catch (\Exception $e){

           }

           return $user->save() ? $user : null;
       }

       return null;
    }
}