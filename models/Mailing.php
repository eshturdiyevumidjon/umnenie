<?php

namespace app\models;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * This is the model class for table "mailing".
 *
 * @property int $id
 * @property string $message Текст
 * @property string $user Дата создании
 * @property string $date_cr За кого отправлено
 */
class Mailing extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mailing';
    }
 
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['message', 'user'], 'string'],
            [['date_cr'], 'safe'],
            [['message'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'message' => 'Текст',
            'user' => 'За кого отправлено',
            'date_cr' => 'Дата создании',
        ];
    }

    public function beforeSave($insert)
    {
        if ($this->isNewRecord)
        {
            $this->date_cr = date('Y-m-d H:i:s');
        }

        return parent::beforeSave($insert);
    }

    public function sendSms($post)
    {
        $phoneList = "";
        $emailList = [];
        if($post['yur'] === '1'){
            $users = Users::find()->where(['type' => 2])->all();
            foreach ($users as $value) {
                if($value->phone != null || $value->phone != '' ) $phoneList .= $value->phone . ";";
                if($value->email != null || $value->email != '' ) $emailList [] = $value->email;
            }
        }

        if($post['fiz'] === '1'){
            $users = Users::find()->where(['type' => 1])->all();
            foreach ($users as $value) {
                if($value->phone != null || $value->phone != '') $phoneList .= $value->phone . ";";
                if($value->email != null || $value->email != '' ) $emailList [] = $value->email;
            }
        }

        if($post['sms'] === '1'){
            $login = 'umnenie';
            $password = 'Umnenie09';
            $clientPhone = $phoneList;  
            $message = $this->message;

            $url_get = 'http://smsc.ru/sys/send.php?login='.$login.'&psw='.$password.'&phones='.$clientPhone.'&mes='.$message.'&charset=utf-8';
            $ch = curl_init();  
            curl_setopt($ch,CURLOPT_URL,$url_get);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
            $result = curl_exec($ch);
            $r = json_decode($result,TRUE);
            curl_close($ch);
        }

        if($post['email'] === '1'){
            Yii::$app
                ->mailer
                ->compose()
                ->setFrom(['umnenie@gmail.com' => 'Umnenie'])
                ->setTo($emailList)
                ->setSubject('Рассылка')
                ->setHtmlBody($this->message)
                ->send();
        }
    }
}
