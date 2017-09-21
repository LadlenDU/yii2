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
    //public $debtor;
    public $name_mixed;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name_mixed'], 'safe'],
            [['id', 'debtor_id', 'public_service_id'], 'integer'],
            [['amount', 'amount_additional_services'], 'number'],
            [['date', 'payment_date'], 'safe'],
        ];
    }

    public function getDebtor()
    {
        return $this->hasOne(Debtor::className(), ['id' => 'debtor_id']);
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
        $query->joinWith(['debtor']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['name_mixed'] = [
            'asc' => ['debtor.name_mixed' => SORT_ASC],
            'desc' => ['debtor.name_mixed' => SORT_DESC],
        ];

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
        ])->andFilterWhere(['like', 'debtor.name_mixed', $this->debtor]);



        return $dataProvider;
    }
}
