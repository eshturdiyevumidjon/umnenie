<?php

namespace app\models;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * This is the model class for table "subscribes".
 *
 * @property int $id
 * @property int $user_id
 * @property int $user_from
 * @property string $date_cr
 *
 * @property Users $userFrom
 * @property Users $user
 */
class Subscribes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'subscribes';
    }
 
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'user_from'], 'integer'],
            [['date_cr'], 'safe'],
            [['user_from'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_from' => 'id']],
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
            'user_id' => 'Подписчик',
            'user_from' => 'За кого подписан',
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
    public function getUserFrom()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_from']);
    }
    public function getUsersForm()
    {
        return ArrayHelper::map(Users::find()->all(), 'id', 'fio');
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
