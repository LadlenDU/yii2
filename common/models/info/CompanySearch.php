<?php

namespace common\models\info;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\info\Company;
use common\models\UserInfo;

/**
 * CompanySearch represents the model behind the search form about `common\models\info\Company`.
 */
class CompanySearch extends Company
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'legal_address_location_id', 'actual_address_location_id', 'CEO'], 'integer'],
            [['full_name', 'short_name', 'INN', 'KPP', 'BIK', 'OGRN', 'checking_account', 'correspondent_account', 'full_bank_name', 'operates_on_the_basis_of', 'phone', 'fax', 'email'], 'safe'],
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
        //TODO: проверить работу: должен быть пользователь обязательно
        $userInfoId = UserInfo::find()->where(['user_id' => Yii::$app->user->identity->getId()])->one()->primaryKey;

        $query = Company::find();

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

        $query->joinWith(['userInfoCompanies'])->andFilterWhere(['user_info_company.user_info_id' => $userInfoId]);

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'legal_address_location_id' => $this->legal_address_location_id,
            'actual_address_location_id' => $this->actual_address_location_id,
            'CEO' => $this->CEO,
        ]);

        $query->andFilterWhere(['like', 'full_name', $this->full_name])
            ->andFilterWhere(['like', 'short_name', $this->short_name])
            ->andFilterWhere(['like', 'INN', $this->INN])
            ->andFilterWhere(['like', 'KPP', $this->KPP])
            ->andFilterWhere(['like', 'BIK', $this->BIK])
            //->andFilterWhere(['like', 'OGRN', $this->OGRN])
            ->andFilterWhere(['like', 'checking_account', $this->checking_account])
            ->andFilterWhere(['like', 'correspondent_account', $this->correspondent_account])
            ->andFilterWhere(['like', 'full_bank_name', $this->full_bank_name])
            ->andFilterWhere(['like', 'operates_on_the_basis_of', $this->operates_on_the_basis_of])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'fax', $this->fax])
            ->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }
}
