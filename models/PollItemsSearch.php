<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PollItems;

/**
 * PollItemsSearch represents the model behind the search form about `app\models\PollItems`.
 */
class PollItemsSearch extends PollItems
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'poll_id'], 'integer'],
            [['option', 'image'], 'safe'],
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
        $query = PollItems::find();

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
            'poll_id' => $this->poll_id,
        ]);

        $query->andFilterWhere(['like', 'option', $this->option])
            ->andFilterWhere(['like', 'image', $this->image]);

        return $dataProvider;
    }
}
