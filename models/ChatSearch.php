<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Chat;
 
/**
 * ChatSearch represents the model behind the search form about `app\models\Chat`.
 */
class ChatSearch extends Chat
{
    /**
     * @inheritdoc
     */ 
    public function rules()
    {
        return [
            [['id', 'from', 'to', 'reply','type','chat_id'], 'integer'],
            [['title', 'file', 'text', 'date_cr', 'deleted'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params 
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Chat::find()
            ->select('chat_id')
            ->from('chat')
            ->groupBy(['chat_id']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]); 

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'from' => $this->from,
            'to' => $this->to,
            'chat_id' => $this->chat_id,
            'type' => $this->type,
            'date_cr' => $this->date_cr,
            'reply' => $this->reply,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'file', $this->file])
            ->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['like', 'deleted', $this->deleted]);

        return $dataProvider;
    }

    /*public function searchByUserId($params, $user_id)
    {
        $query = Chat::find()
            ->select('chat_id')
            ->from('chat')
            ->where(['from' => $user_id, 'type' => 1])
            ->orWhere(['to' => $user_id, 'type' => 1])
            ->groupBy(['chat_id']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]); 

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'from' => $this->from,
            'to' => $this->to,
            'chat_id' => $this->chat_id,
            'type' => $this->type,
            'date_cr' => $this->date_cr,
            'reply' => $this->reply,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'file', $this->file])
            ->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['like', 'deleted', $this->deleted]);

        $array = [];
        foreach ($dataProvider->getModels() as $model) {
            $chat = Chat::find()->where(['chat_id' => $model->chat_id])->one();

            $to = null;
            if($chat->from == $user_id) $to = $chat->to;
            if($chat->to == $user_id) $to = $chat->from;
            $user = Users::findOne($to);
            
            $array [] = [
                'chat_id' => $model->chat_id,
                'user_id' => $to,
                'userFIO' => $user->getFIO(),
                'userName' => $user->username,
                'userImage' => $user->getImage(),
            ];
        }

        return $array;
    }*/

    public function searchByUserId($params, $user_id)
    {
        $chat = Chat::find()->where(['type' => 3, 'chat_id' => 'admin_chat_'.$user_id])->one();
        if($chat == null){
            $admin = Users::find()->where(['type' => 3])->one();
            $chat = new Chat();
            $chat->type = 3;
            $chat->chat_id = 'admin_chat_'.$user_id;
            $chat->from = $admin->id;
            $chat->to = $user_id;
            $chat->text = 'Добро пожаловать в платформу Umnenie! Если у вас возникнут какие-либо вопросы, можете смело обратиться к Службе поддержки';
            $chat->save();
        }

        $query = Chat::find()
            ->select('chat_id')
            ->from('chat')
            ->where(['from' => $user_id, 'type' => 1])
            ->orWhere(['to' => $user_id, 'type' => 1])
            ->groupBy(['chat_id']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]); 

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'from' => $this->from,
            'to' => $this->to,
            'chat_id' => $this->chat_id,
            'type' => $this->type,
            'date_cr' => $this->date_cr,
            'reply' => $this->reply,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'file', $this->file])
            ->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['like', 'deleted', $this->deleted]);

        $array = [];
        $chat = Chat::find()->where(['type' => 3, 'chat_id' => 'admin_chat_'.$user_id])->one();
        if($chat != null) {
            $to = null;
            if($chat->from == $user_id) $to = $chat->to;
            if($chat->to == $user_id) $to = $chat->from;
            $user = Users::findOne($to);

            $array [] = [
                'chat_id' => $chat->chat_id,
                'user_id' => $to,
                'userFIO' => 'Администратор', //$user->getFIO(),
                'userName' => $user->username,
                'userImage' => $user->getImage(),
            ];
        }
        foreach ($dataProvider->getModels() as $model) {
            $chat = Chat::find()->where(['chat_id' => $model->chat_id])->one();

            $to = null;
            if($chat->from == $user_id) $to = $chat->to;
            if($chat->to == $user_id) $to = $chat->from;
            $user = Users::findOne($to);
            if($user != null){
                $array [] = [
                    'chat_id' => $model->chat_id,
                    'user_id' => $to,
                    'userFIO' => $user->getFIO(),
                    'userName' => $user->username,
                    'userImage' => $user->getImage(),
                ];
            }
        }

        return $array;
    }
}
