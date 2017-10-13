<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Accrual;

/**
 * AccrualSearch represents the model behind the search form about `common\models\Accrual`.
 */
class AccrualSearch extends Accrual
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'debtor_id'], 'integer'],
            [['accrual_date'], 'safe'],
            [['accrual', 'single', 'additional_adjustment', 'subsidies'], 'number'],
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
        $query = Accrual::find();

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
            'accrual_date' => $this->accrual_date,
            'accrual' => $this->accrual,
            'single' => $this->single,
            'additional_adjustment' => $this->additional_adjustment,
            'subsidies' => $this->subsidies,
        ]);

        return $dataProvider;
    }
}
