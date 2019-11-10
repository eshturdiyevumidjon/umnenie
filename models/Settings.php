<?php

namespace app\models;

use Yii; 

/**
 * This is the model class for table "settings".
 *
 * @property int $id
 * @property string $name
 * @property string $key
 * @property string $value
 */
class Settings extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'settings';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'key'], 'string', 'max' => 255],
            [['value'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Наименование',
            'key' => 'Ключ',
            'value' => 'Значение',
        ];
    }
}
