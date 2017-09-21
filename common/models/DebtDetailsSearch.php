<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\DebtDetails;

/**
 * DebtDetailsSearch represents the model behind the search form about `common\models\DebtDetails`.
 */
class DebtDetailsSearch extends DebtDetails
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['debtor'], 'safe'],
            [['id', 'debtor_id', 'public_service_id'], 'integer'],
            [['amount', 'amount_additional_services'], 'number'],
            [['date', 'payment_date'], 'safe'],
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
        $query = DebtDetails::find();

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
            'debtor_id' => $this->debtor_id,
            'amount' => $this->amount,
            'amount_additional_services' => $this->amount_additional_services,
            'date' => $this->date,
            'payment_date' => $this->payment_date,
            'public_service_id' => $this->public_service_id,
        ]);

        return $dataProvider;
    }
}
