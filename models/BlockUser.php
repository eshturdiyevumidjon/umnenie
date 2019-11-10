<?php

namespace app\models;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * This is the model class for table "block_user".
 *
 * @property int $id
 * @property int $user_from Пользователь
 * @property int $user_to Кто заблокирован
 * @property string $date_cr Дата блокировки
 *
 * @property Users $userFrom
 * @property Users $userTo
 */
class BlockUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc} 
     */
    public static function tableName()
    {
        return 'block_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_from', 'user_to'], 'integer'],
            [['date_cr'], 'safe'],
            [['user_from'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_from' => 'id']],
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
            'user_from' => 'Пользователь',
            'user_to' => 'Кто заблокирован',
            'date_cr' => 'Дата блокировки',
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
    public function getUserFroms()
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
    public function getUserTos()
    {
        return ArrayHelper::map(Users::find()->all(), 'id', 'fio');
    }
}
