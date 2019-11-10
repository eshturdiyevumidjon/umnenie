<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Like;

/**
 * LikeSearch represents the model behind the search form about `app\models\Like`.
 */
class LikeSearch extends Like
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
        $query = Like::find();

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

    public function searchByCabinet($page, $user_id)
    {
        $query = Like::find()->where(['user_id' => $user_id]);
        $defaultPageSize = Yii::$app->params['defaultPageSize'];

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        //$this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $result = [];
        foreach ($dataProvider->getModels() as $value) {
           $result [] = $value->poll_id;
        }

        $query = Polls::find()->where(['id' => $result]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => $defaultPageSize, //set page size here
                'page' => $page,
            ]
        ]);

        return $dataProvider;
    }
}
