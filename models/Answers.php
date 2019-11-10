<?php

namespace app\models;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * This is the model class for table "answers".
 *
 * @property int $id
 * @property string $comment Комментария
 * @property int $poll_id Опрос
 * @property int $poll_item_id Пункт опроса
 * @property int $user_id Пользователь
 *
 * @property Polls $poll
 * @property PollItems $pollItem 
 * @property Users $user 
 */
class Answers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'answers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['comment'], 'string'],
            [['poll_id', 'poll_item_id', 'user_id'], 'integer'],
            [['poll_id'], 'exist', 'skipOnError' => true, 'targetClass' => Polls::className(), 'targetAttribute' => ['poll_id' => 'id']],
            [['poll_item_id'], 'exist', 'skipOnError' => true, 'targetClass' => PollItems::className(), 'targetAttribute' => ['poll_item_id' => 'id']],
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
            'comment' => 'Комментария',
            'poll_id' => 'Опрос',
            'poll_item_id' => 'Пункт опроса',
            'user_id' => 'Пользователь',
        ];
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
    public function getPollItem()
    {
        return $this->hasOne(PollItems::className(), ['id' => 'poll_item_id']);
    }
    public function getPollItems()
    {
        return ArrayHelper::map(PollItems::find()->all(), 'id', 'id');
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
