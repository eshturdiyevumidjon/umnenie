<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "verification".
 *
 * @property int $id
 * @property string $sms_code Sms Code
 * @property string $phone Телефон номер
 * @property int $status Статус
 */
class Verification extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'verification';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['sms_code', 'phone'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sms_code' => 'Sms Code',
            'phone' => 'Телефон номер',
            'status' => 'Статус',
        ];
    }
}
