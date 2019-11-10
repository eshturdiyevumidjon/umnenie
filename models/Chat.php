<?php

namespace app\models;
use yii\helpers\ArrayHelper;
use Yii;

class Chat extends \yii\db\ActiveRecord
{ 
    /**
     * {@inheritdoc}
     */
    public $files;
    public $users; 
    public static function tableName()
    {
        return 'chat';
    }

    /**  
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['from', 'to', 'reply', 'deleted','type'], 'integer'],
            [['text'], 'string'],
            [['date_cr'], 'safe'],
            [['files'], 'file', 'extensions' => 'png, jpg'],

            [['title', 'file', 'chat_id'], 'string', 'max' => 255],
            [['from'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['from' => 'id']],
            [['to'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['to' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Тип',
            'chat_id' => 'Чат',
            'date_cr' => 'Дата создании',
            'from' => 'Создатель',
            'to' => 'Получатель',
            'users' => 'Получатели',
            'title' => 'Заголовок',
            'file' => 'Файл',
            'files' => 'Файл',
            'text' => 'Текст',
            'reply' => 'Ответить',
            'deleted' => 'Удалено',
        ];
    }
    public function beforeSave($insert)
    {
        if ($this->isNewRecord)
        {
            $this->date_cr = date("Y-m-d H:i:s");
            if($this->deleted == null) $this->deleted = 0;
            if($this->from == null) $this->from = Yii::$app->user->identity->id;
        }
        return parent::beforeSave($insert);
    }
    public function getType()
    {
        return ArrayHelper::map([
            ['id' => '1','type' => 'Чат',],
            ['id' => '2','type' => 'Комментарий',],
            ['id' => '3','type' => 'Чат с админом',],
        ], 'id', 'type');
    }
    /** 
     * @return \yii\db\ActiveQuery
     */
    public function getUserFrom()
    {
        return $this->hasOne(Users::className(), ['id' => 'from']);
    }
    public function getUserFroms()
    {
        return ArrayHelper::map(Users::find()->all(), 'id', 'fio');
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserTo()
    {
        return $this->hasOne(Users::className(), ['id' => 'to']);
    }
    public function getUsers()
    {
        return ArrayHelper::map(Users::find()->all(), 'id', 'fio');
    }
    public function getUsersList()
    {
        $users = Users::find()->all();
        return ArrayHelper::map($users, 'id', 'fio');
    }

    public function foldersize($path) 
    {
        $total_size = 0;
        $files = scandir($path);
        $cleanPath = rtrim($path, '/'). '/';

        foreach($files as $t) {
            if ($t<>"." && $t<>"..") {
                $currentFile = $cleanPath . $t;
                if (is_dir($currentFile)) {
                    $size = Inbox::foldersize($currentFile);
                    $total_size += $size;
                }
                else {
                    $size = filesize($currentFile);
                    $total_size += $size;
                }
            }   
        }

        return $total_size;
    }

    public function format_size($size) 
    {
        $units = explode(' ', 'B KB MB GB TB PB');
        $mod = 1024;
        for ($i = 0; $size > $mod; $i++) {
            $size /= $mod;
        }
        $endIndex = strpos($size, ".")+3;
        return substr( $size, 0, $endIndex).' '.$units[$i];
    }

    public function getFile()
    {
        $adminSiteName = Yii::$app->params['adminSiteName'];
        if($this->file == null) $file = null;
        else $file = "{$adminSiteName}/uploads/chat/{$this->file}";

        return $file;
    }

    public static function getCommentList($poll_id)
    {
        $siteName = Yii::$app->params['siteName'];
        $chatName = "#poll-{$poll_id}";
        $comments = Chat::find()->where(['chat_id' => $chatName, 'type' => 2])->all();
        $count = Chat::find()->where(['chat_id' => $chatName, 'type' => 2])->count();
        $result = [];
        foreach ($comments as $comment) {
            $rtl = 'left';
            if(!Yii::$app->user->isGuest && $comment->userFrom->id == Yii::$app->user->identity->id ) $trl = 'right';
            $result [] = [
                'user_name' => $comment->userFrom->username,
                'user_fio' => $comment->userFrom->getFIO(),
                'user_id' => $comment->userFrom->id,
                //'user_profile' => $siteName . '/v1/polls/user-profil?user_id=' . $comment->userFrom->id,
                'avatar' => $comment->userFrom->getImage(),
                'text' => $comment->text,
                'file' => $comment->getFile(),
                'date_cr' => date('H:i d.m.Y', strtotime($comment->date_cr)),
                'rtl' => $rtl,
            ];
        }

        $var = [
            'count' => $count,
            'items' => $result,
        ];
        return $var;
    }

    public static function getActiveMessages($active, $user)
    {
        $activeMessages = [];
        $chats = Chat::find()->where(['chat_id' => $active, 'deleted' => 0])->all();
        foreach ($chats as $chat) {
            if($chat->from == $user->id){
                $activeMessages [] = [
                    'my_sms' => 1,
                    'user_from' => $chat->userFrom->id,
                    'user_to' => $chat->userTo->id,
                    'userAvatar' => $chat->userFrom->getImage(),
                    'userName' => $chat->userFrom->username,
                    'userFIO' => $chat->userFrom->getFIO(),
                    'userLink' => $chat->userFrom->getUserCabinetLink(),
                    'date_cr' => $chat->date_cr,
                    'file' => $chat->getFile(),
                    'text' => $chat->text,
                ];
            }
            else{
                $activeMessages [] = [
                    'my_sms' => 0,
                    'user_from' => $chat->userFrom->id,
                    'user_to' => $chat->userTo->id,
                    'userAvatar' => $chat->userFrom->getImage(),
                    'userName' => $chat->userFrom->username,
                    'userFIO' => $chat->userFrom->getFIO(),
                    'user_link' => $chat->userFrom->getUserCabinetLink(),
                    'date_cr' => $chat->date_cr,
                    'file' => $chat->getFile(),
                    'text' => $chat->text,
                ];
            }
        }

        return $activeMessages;
    }
}
