<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Debtor;

/**
 * DebtorSearch represents the model behind the search form about `common\models\Debtor`.
 */
class DebtorSearch extends Debtor
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'ownership_type_id', 'location_id', 'name_id', 'user_id', 'status_id'], 'integer'],
            [['phone', 'LS_EIRC', 'LS_IKU_provider', 'IKU', 'expiration_start', 'single', 'additional_adjustment', 'subsidies'], 'safe'],
            [['space_common', 'space_living', 'debt_total'], 'number'],
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
        $query = Debtor::find()->with('location');

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
            'space_common' => $this->space_common,
            'space_living' => $this->space_living,
            'ownership_type_id' => $this->ownership_type_id,
            'location_id' => $this->location_id,
            'name_id' => $this->name_id,
            'expiration_start' => $this->expiration_start,
            'debt_total' => $this->debt_total,
            'user_id' => $this->user_id,
            'status_id' => $this->status_id,
        ]);

        $query->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'LS_EIRC', $this->LS_EIRC])
            ->andFilterWhere(['like', 'LS_IKU_provider', $this->LS_IKU_provider])
            ->andFilterWhere(['like', 'IKU', $this->IKU])
            ->andFilterWhere(['like', 'single', $this->single])
            ->andFilterWhere(['like', 'additional_adjustment', $this->additional_adjustment])
            ->andFilterWhere(['like', 'subsidies', $this->subsidies]);

        return $dataProvider;
    }
}
