<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Location;

/**
 * LocationSearch represents the model behind the search form about `common\models\Location`.
 */
class LocationSearch extends Location
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['region', 'regionId', 'district', 'districtId', 'city', 'cityId', 'street', 'streetId', 'building', 'buildingId', 'appartment', 'zip_code', 'full_address'], 'safe'],
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
        $query = Location::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'region', $this->region])
            ->andFilterWhere(['like', 'regionId', $this->regionId])
            ->andFilterWhere(['like', 'district', $this->district])
            ->andFilterWhere(['like', 'districtId', $this->districtId])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'cityId', $this->cityId])
            ->andFilterWhere(['like', 'street', $this->street])
            ->andFilterWhere(['like', 'streetId', $this->streetId])
            ->andFilterWhere(['like', 'building', $this->building])
            ->andFilterWhere(['like', 'buildingId', $this->buildingId])
            ->andFilterWhere(['like', 'appartment', $this->appartment])
            ->andFilterWhere(['like', 'zip_code', $this->zip_code])
            ->andFilterWhere(['like', 'full_address', $this->full_address]);

        return $dataProvider;
    }
}
