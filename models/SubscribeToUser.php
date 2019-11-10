<?php

namespace app\models;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * This is the model class for table "subscribe_to_user".
 *
 * @property int $id
 * @property int $user_id Подписчик
 * @property int $user_to Пользователь
 * @property string $date_cr Дата и время подписки
 *
 * @property Users $user
 * @property Users $userTo
 */
class SubscribeToUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'subscribe_to_user';
    }

    /** 
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'user_to'], 'integer'],
            [['date_cr'], 'safe'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['user_to'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_to' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Подписчик',
            'user_to' => 'Пользователь',
            'date_cr' => 'Дата и время подписки',
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
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
    public function getUsers()
    {
        return ArrayHelper::map(Users::find()->all(), 'id', 'fio');
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserTo()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_to']);
    }
    public function getUsersTo()
    {
        return ArrayHelper::map(Users::find()->all(), 'id', 'fio');
    }
}
