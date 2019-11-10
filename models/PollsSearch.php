<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Polls;

/**
 * PollsSearch represents the model behind the search form about `app\models\Polls`.
 */
class PollsSearch extends Polls
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'category_id','type', 'visibility', 'term', 'status', 'view_comment'], 'integer'],
            [['date_cr', 'date_end', 'hashtags', 'publications','question','image'], 'safe'],
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
        $query = Polls::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id'=>SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'type' => $this->type,
            'date_cr' => $this->date_cr,
            'date_end' => $this->date_end,
            'category_id' => $this->category_id,
            'visibility' => $this->visibility,
            'term' => $this->term,
            'status' => $this->status,
            'view_comment' => $this->view_comment,
        ]);

        $query->andFilterWhere(['like', 'hashtags', $this->hashtags])
            ->andFilterWhere(['like', 'publications', $this->publications]);

        return $dataProvider;
    }

    public function searchDraft($params, $user_id, $status)
    {
        $query = Polls::find()->where(['user_id' => $user_id, 'status' => $status]);

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
            'user_id' => $this->user_id,
            'type' => $this->type,
            'date_cr' => $this->date_cr,
            'date_end' => $this->date_end,
            'category_id' => $this->category_id,
            'visibility' => $this->visibility,
            'term' => $this->term,
            'status' => $this->status,
            'view_comment' => $this->view_comment,
        ]);

        $query->andFilterWhere(['like', 'hashtags', $this->hashtags])
            ->andFilterWhere(['like', 'publications', $this->publications]);

        return $dataProvider;
    }

    public function searchReferal($params, $user_id)
    {
        $query = Polls::find()->where(['referal_id' => $user_id]);

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
            'user_id' => $this->user_id,
            'type' => $this->type,
            'date_cr' => $this->date_cr,
            'date_end' => $this->date_end,
            'category_id' => $this->category_id,
            'visibility' => $this->visibility,
            'term' => $this->term,
            'status' => $this->status,
            'view_comment' => $this->view_comment,
        ]);

        $query->andFilterWhere(['like', 'hashtags', $this->hashtags])
            ->andFilterWhere(['like', 'publications', $this->publications]);

        return $dataProvider;
    }
}
