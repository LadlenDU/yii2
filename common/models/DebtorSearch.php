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
            [['id', 'privatized', 'general_manager_id'], 'integer'],
            [['first_name', 'second_name', 'patronymic', 'name_mixed', 'address', 'locality', 'street', 'building', 'appartment', 'phone', 'LS_EIRC', 'LS_IKU_provider', 'IKU'], 'safe'],
            [['space_common', 'space_living'], 'number'],
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
        $query = Debtor::find();

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
            'privatized' => $this->privatized,
            'general_manager_id' => $this->general_manager_id,
        ]);

        $query->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'second_name', $this->second_name])
            ->andFilterWhere(['like', 'patronymic', $this->patronymic])
            ->andFilterWhere(['like', 'name_mixed', $this->name_mixed])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'locality', $this->locality])
            ->andFilterWhere(['like', 'street', $this->street])
            ->andFilterWhere(['like', 'building', $this->building])
            ->andFilterWhere(['like', 'appartment', $this->appartment])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'LS_EIRC', $this->LS_EIRC])
            ->andFilterWhere(['like', 'LS_IKU_provider', $this->LS_IKU_provider])
            ->andFilterWhere(['like', 'IKU', $this->IKU]);

        return $dataProvider;
    }
}
