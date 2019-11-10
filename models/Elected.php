<?php

namespace app\models;
use yii\helpers\ArrayHelper;    
use Yii;

/**
 * This is the model class for table "elected".
 *
 * @property int $id
 * @property int $poll_id Опросы
 * @property int $user_id Пользователи
 * @property string $cr_date Дата создания
 *
 * @property Polls $poll
 * @property Users $user
 */
class Elected extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'elected';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['poll_id', 'user_id'], 'integer'],
            [['cr_date'], 'safe'],
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
            'poll_id' => 'Опросы',
            'user_id' => 'Пользователи',
            'cr_date' => 'Дата создания',
        ];
    }
    public function beforeSave($insert)
    {
        if ($this->isNewRecord)
        {
            $this->cr_date = date("Y-m-d H:i:s");
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
}
