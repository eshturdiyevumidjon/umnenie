<?php

namespace app\models;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * This is the model class for table "poll_items".
 *
 * @property int $id
 * @property int $poll_id Опросы
 * @property string $option Вариант ответа
 * @property string $image Картинка
 *
 * @property Polls $poll 
 */
class PollItems extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc} 
     */
    public $other_image;
    public static function tableName()
    {
        return 'poll_items';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['poll_id'], 'integer'],
            [['option', 'image'], 'string', 'max' => 255],
            // [['poll_id'], 'required'],
            [['poll_id'], 'exist', 'skipOnError' => true, 'targetClass' => Polls::className(), 'targetAttribute' => ['poll_id' => 'id']],
            [['other_image'], 'file'],
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
            'option' => 'Вариант ответа',
            'image' => 'Картинка',
            'other_image' => 'Картинка',
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

    public function getImage()
    {
        $adminSiteName = Yii::$app->params['adminSiteName'];
        if($this->poll->type == 1) {
            if($this->image == null) $image = "{$adminSiteName}/img/no_image.jpg";
            else $image = "{$adminSiteName}/uploads/pollitem/{$this->image}";
            return $image;
        }
        else {
            return null;
        }
    }

    public function getCount()
    {
        $count = Answers::find()->where(['poll_id' => $this->poll_id])->count();
        $thisCount = Answers::find()->where(['poll_item_id' => $this->id])->count();
        if($count == 0) return 0;
        else return round(100 * ($thisCount / $count), 0);
    }

    public function getSelectedUsersAvatar()
    {
        $answers = Answers::find()
            ->where(['poll_id' => $this->poll_id, 'poll_item_id' => $this->id])
            ->orderBy(['id' => SORT_DESC])
            ->limit(3)
            ->all();
        $result = [];
        foreach ($answers as $answer) {
            $result [] = $answer->user->getImage();
        }
        return $result;
    }
}
