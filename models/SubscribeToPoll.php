<?php

namespace app\models;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * This is the model class for table "subscribe_to_poll".
 *
 * @property int $id
 * @property int $user_id Пользователь
 * @property int $poll_id Опрос
 * @property string $date_cr Дата подписки
 *
 * @property Polls $poll
 * @property Users $user
 */
class SubscribeToPoll extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'subscribe_to_poll';
    }
 
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'poll_id'], 'integer'],
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
            'poll_id' => 'Опрос',
            'date_cr' => 'Дата подписки',
        ];
    }
    public function beforeSave($insert)
    {
        if ($this->isNewRecord)
        {
            $this->date_cr = date("Y-m-d H:i:s");
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
    public function getPolls()
    {
        return ArrayHelper::map(Polls::find()->all(), 'id', 'id');
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
    public function getUsers()
    {
        return ArrayHelper::map(Users::find()->all(), 'id', 'fio');
    }
}
