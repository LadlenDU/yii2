<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Court;

/**
 * CourtSearch represents the model behind the search form about `common\models\Court`.
 */
class CourtSearch extends Court
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'address', 'region', 'regionId', 'district', 'districtId', 'city', 'cityId', 'street', 'streetId', 'building', 'buildingId', 'phone', 'name_of_payee', 'BIC', 'beneficiary_account_number', 'INN', 'KPP', 'OKTMO', 'beneficiary_bank_name', 'KBK'], 'safe'],
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
        $query = Court::find();

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

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'region', $this->region])
            ->andFilterWhere(['like', 'regionId', $this->regionId])
            ->andFilterWhere(['like', 'district', $this->district])
            ->andFilterWhere(['like', 'districtId', $this->districtId])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'cityId', $this->cityId])
            ->andFilterWhere(['like', 'street', $this->street])
            ->andFilterWhere(['like', 'streetId', $this->streetId])
            ->andFilterWhere(['like', 'building', $this->building])
            ->andFilterWhere(['like', 'buildingId', $this->buildingId])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'name_of_payee', $this->name_of_payee])
            ->andFilterWhere(['like', 'BIC', $this->BIC])
            ->andFilterWhere(['like', 'beneficiary_account_number', $this->beneficiary_account_number])
            ->andFilterWhere(['like', 'INN', $this->INN])
            ->andFilterWhere(['like', 'KPP', $this->KPP])
            ->andFilterWhere(['like', 'OKTMO', $this->OKTMO])
            ->andFilterWhere(['like', 'beneficiary_bank_name', $this->beneficiary_bank_name])
            ->andFilterWhere(['like', 'KBK', $this->KBK]);

        return $dataProvider;
    }
}
