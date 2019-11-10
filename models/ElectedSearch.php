<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Elected;

/**
 * ElectedSearch represents the model behind the search form about `app\models\Elected`.
 */
class ElectedSearch extends Elected
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'poll_id', 'user_id'], 'integer'],
            [['cr_date'], 'safe'],
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
        $query = Elected::find();

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
            'user_id' => $this->user_id,
            'cr_date' => $this->cr_date,
        ]);

        return $dataProvider;
    }

    public function searchByCabinet($params, $user_id)
    {
        $query = Elected::find()->where(['user_id' => $user_id]);

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
            'user_id' => $this->user_id,
            'cr_date' => $this->cr_date,
        ]);

        $result = [];
        foreach ($dataProvider->getModels() as $value) {
           $result [] = $value->poll_id;
        }

        $query = Polls::find()->where(['id' => $result]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $dataProvider;
    }
}
