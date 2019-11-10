<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "complaints".
 *
 * @property int $id
 * @property int $user_id Пользователь
 * @property string $text Текст
 * @property string $date_cr Дата создании
 * @property int $poll_id Опрос
 *
 * @property Polls $poll
 * @property Users $user
 */
class Complaints extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'complaints';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'poll_id'], 'integer'],
            [['text', 'poll_id'], 'required'],
            [['text'], 'string'],
            [['date_cr'], 'safe'],
            [['poll_id'], 'exist', 'skipOnError' => true, 'targetClass' => Polls::className(), 'targetAttribute' => ['poll_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Пользователь',
            'text' => 'Текст',
            'date_cr' => 'Дата создании',
            'poll_id' => 'Опрос',
        ];
    }
    public function beforeSave($insert)
    {
        if ($this->isNewRecord)
        {
            $this->date_cr = date("Y-m-d H:i:s");
            $this->user_id = \Yii::$app->user->identity->id;
        }
        return parent::beforeSave($insert);
    }
    /** 
     * @return \yii\db\ActiveQuery
     */
    public function getPoll()
    {
        return $this->hasOne(Polls::className(), ['id' => 'poll_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    public function statusVerified()
    {
        $count = Complaints::find()->where(['poll_id' => $this->poll_id])->count();
        $answerCount = Answers::find()->where(['poll_id' => $this->poll_id])->count();
        if($answerCount != 0) $percent = 100 * $count / $answerCount;
        else $percent = 0;
        if($percent > 10 && $count > 3){
            $poll = Polls::findOne($this->poll_id);
            $poll->status = 3;
            $poll->save();

            $login = 'umnenie';
            $password = 'Umnenie09';
            $clientPhone = $poll->user->phone;
            $message = '«Ваш опрос был заблокирован администрацией сайта». Ид опроса = ' . $poll->id;

            $url_get = 'http://smsc.ru/sys/send.php?login='.$login.'&psw='.$password.'&phones='.$clientPhone.'&mes='.$message.'&charset=utf-8';
            $ch = curl_init();  
            curl_setopt($ch,CURLOPT_URL,$url_get);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
            $result = curl_exec($ch);
            $r = json_decode($result,TRUE);
            curl_close($ch);

            Yii::$app
                ->mailer
                ->compose()
                ->setFrom(['umnenie@gmail.com' => 'Umnenie'])
                ->setTo($poll->user->email)
                ->setSubject('Рассылка')
                ->setHtmlBody($message)
                ->send();

            $phoneList = "";
            $emailList = [];
            $users = Users::find()->where(['type' => 3])->all();
            foreach ($users as $value) {
                if($value->phone != null || $value->phone != '' ) $phoneList .= $value->phone . ";";
                if($value->email != null || $value->email != '' ) $emailList [] = $value->email;
            }

            $clientPhone = $phoneList;
            $message = '«Опрос заблокирован». Ид опроса = ' . $poll->id;

            $url_get = 'http://smsc.ru/sys/send.php?login='.$login.'&psw='.$password.'&phones='.$clientPhone.'&mes='.$message.'&charset=utf-8';
            $ch = curl_init();  
            curl_setopt($ch,CURLOPT_URL,$url_get);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
            $result = curl_exec($ch);
            $r = json_decode($result,TRUE);
            curl_close($ch);

            Yii::$app
                ->mailer
                ->compose()
                ->setFrom(['umnenie@gmail.com' => 'Umnenie'])
                ->setTo($emailList)
                ->setSubject('Рассылка')
                ->setHtmlBody($message)
                ->send();
        }
    }
}
