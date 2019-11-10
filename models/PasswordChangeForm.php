<?php
namespace app\models\api;
use yii\base\Model;

class PasswordChangeForm extends Model
{
    public $password_now;
    public $password;
    public $password_repeat;

    private $_user;

    public function rules()
    {
        return [
            [['password_now', 'password', 'password_repeat'], 'required'],
            ['password', 'string', 'min' => 6],
            ['password_repeat','checkPass'],
            ['password_now','checkPassword'],
        ];
    }
    
    public function checkPassword($attribute, $params)
    {
        $user = \app\models\User::find()->where([
            'username'=>\Yii::$app->user->identity->username
        ])->one();
        if( !$user->validatePassword($this->password_now))
            $this->addError($attribute,'Sizning hozirgi parolingiz noto`g`ri');
    }


    public function checkPass($attribute, $params)
    {
        if($this->password!=$this->password_repeat)
            $this->addError($attribute, "Yangi parolingizni tekshirib qaytadan kirgizing!");
    }

    public function setPassword(){
        $user=\app\models\User::findOne(\Yii::$app->user->getId());
        $user->password_hash=\Yii::$app->getSecurity()->generatePasswordHash($this->password);
        $user->save(false);
        return true;
    }

    public function resetPassword()
    {
        $user = $this->_user;
        $user->setPassword($this->password);
        $user->removePasswordResetToken();
        return $user->save(false);
    }
}