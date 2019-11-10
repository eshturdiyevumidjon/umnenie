<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Users;

/** 
 * UsersSearch represents the model behind the search form about `app\models\Users`.
 */
class UsersSearch extends Users
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type','category_id','specialization_id','gender', 'expire_at'], 'integer'],
            [['registry_date','birthday','comments','address','factual_address','facebook_user_id', 'vk_user_id','username','password','phone','foto','fio', 'facebook', 'telegram','twitter','email','org_name','site','mobile_phone','logo', 'access_token', 'google_user_id'], 'safe'],
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
        $query = Users::find();

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
            'type' => $this->type,
            'category_id' => $this->category_id,
            'specialization_id' => $this->specialization_id,
            'gender' => $this->gender,
            'expire_at' => $this->expire_at,
            'google_user_id' => $this->google_user_id,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'foto', $this->foto])
            ->andFilterWhere(['like', 'facebook_user_id', $this->facebook_user_id])
            ->andFilterWhere(['like', 'vk_user_id', $this->vk_user_id])
            ->andFilterWhere(['like', 'registry_date', $this->registry_date])
            ->andFilterWhere(['like', 'comments', $this->comments])
            ->andFilterWhere(['like', 'fio', $this->fio])
            ->andFilterWhere(['like', 'birthday', $this->birthday])
            ->andFilterWhere(['like', 'facebook', $this->facebook])
            ->andFilterWhere(['like', 'telegram', $this->telegram])
            ->andFilterWhere(['like', 'twitter', $this->twitter])
            ->andFilterWhere(['like', 'access_token', $this->access_token])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'org_name', $this->org_name])
            ->andFilterWhere(['like', 'factual_address', $this->factual_address])
            ->andFilterWhere(['like', 'site', $this->site])
            ->andFilterWhere(['like', 'mobile_phone', $this->mobile_phone])
            ->andFilterWhere(['like', 'logo', $this->logo]);

        return $dataProvider;
    }
}
