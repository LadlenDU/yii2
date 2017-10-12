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
    public $LS_EIRC;
    public $LS_IKU_provider;
    public $IKU;
    public $name_mixed;
    public $city;
    public $street;
    public $building;
    public $appartment;
    //public $privatized;
    public $phone;
    public $debtor_id;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['LS_EIRC', 'LS_IKU_provider', 'IKU', 'name_mixed', 'city', 'street', 'building', 'appartment', 'phone'], 'safe'],
            //[['id', 'ownership_type_id', 'debtor_id', 'public_service_id'], 'integer'],
            [['LS_EIRC', 'LS_IKU_provider', 'IKU', 'name_mixed', 'city', 'street', 'building', 'appartment'], 'safe'],
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
        $query->joinWith(['debtor']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['LS_EIRC'] = [
            'asc' => ['debtor.LS_EIRC' => SORT_ASC],
            'desc' => ['debtor.LS_EIRC' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['LS_IKU_provider'] = [
            'asc' => ['debtor.LS_IKU_provider' => SORT_ASC],
            'desc' => ['debtor.LS_IKU_provider' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['IKU'] = [
            'asc' => ['debtor.IKU' => SORT_ASC],
            'desc' => ['debtor.IKU' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['name_mixed'] = [
            'asc' => ['debtor.name_mixed' => SORT_ASC],
            'desc' => ['debtor.name_mixed' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['city'] = [
            'asc' => ['debtor.city' => SORT_ASC],
            'desc' => ['debtor.city' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['street'] = [
            'asc' => ['debtor.street' => SORT_ASC],
            'desc' => ['debtor.street' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['building'] = [
            'asc' => ['debtor.building' => SORT_ASC],
            'desc' => ['debtor.building' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['appartment'] = [
            'asc' => ['debtor.appartment' => SORT_ASC],
            'desc' => ['debtor.appartment' => SORT_DESC],
        ];
        /*$dataProvider->sort->attributes['privatized'] = [
            'asc' => ['debtor.privatized' => SORT_ASC],
            'desc' => ['debtor.privatized' => SORT_DESC],
        ];*/
        /*$dataProvider->sort->attributes['phone'] = [
            'asc' => ['debtor.phone' => SORT_ASC],
            'desc' => ['debtor.phone' => SORT_DESC],
        ];*/

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'debtor_id' => empty($params['debtor_id']) ? $this->debtor_id : $params['debtor_id'],    //TODO: не костыль, а костылище - исправить !!!!
            'amount' => $this->amount,
            'amount_additional_services' => $this->amount_additional_services,
            'date' => $this->date,
            'payment_date' => $this->payment_date,
            'public_service_id' => $this->public_service_id,
        ])
            ->andFilterWhere(['like', 'debtor.LS_EIRC', $this->LS_EIRC])
            ->andFilterWhere(['like', 'debtor.LS_IKU_provider', $this->LS_IKU_provider])
            ->andFilterWhere(['like', 'debtor.IKU', $this->IKU])
            ->andFilterWhere(['like', 'debtor.name_mixed', $this->name_mixed])
            ->andFilterWhere(['like', 'debtor.city', $this->city])
            ->andFilterWhere(['like', 'debtor.street', $this->street])
            ->andFilterWhere(['like', 'debtor.building', $this->building])
            ->andFilterWhere(['like', 'debtor.appartment', $this->appartment])
            //->andFilterWhere(['like', 'debtor.privatized', $this->privatized])
            ->andFilterWhere(['like', 'debtor.phone', $this->phone]);

        return $dataProvider;
    }
}
