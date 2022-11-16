<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

use backend\models\Order;

/**
 * OrderSearch represents the model behind the search form about `backend\models\Order`.
 */
class OrderSearch extends Order
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'delivery_method_id', 'payment_metod_id', 'order_status_id'], 'integer'],
            [['code', 'user_id', 'user_name', 'user_middlename', 'user_lastname', 'user_email', 'user_phone', 'user_adress', 'user_comment', 'date_create', 'date_payment'], 'safe'],
            [['total_sum'], 'number'],
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
        $query = Order::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'date_create' => SORT_DESC,
                ]
            ],
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
            'delivery_method_id' => $this->delivery_method_id,
            'payment_metod_id' => $this->payment_metod_id,
            'total_sum' => $this->total_sum,
            'order_status_id' => $this->order_status_id,
            'date_create' => $this->date_create,
            'date_payment' => $this->date_payment,
            'type' => $this->type,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'user_id', $this->user_id])
            ->andFilterWhere(['like', 'user_name', $this->user_name])
            ->andFilterWhere(['like', 'user_middlename', $this->user_middlename])
            ->andFilterWhere(['like', 'user_lastname', $this->user_lastname])
            ->andFilterWhere(['like', 'user_email', $this->user_email])
            ->andFilterWhere(['like', 'user_phone', $this->user_phone])
            ->andFilterWhere(['like', 'user_adress', $this->user_adress])
            ->andFilterWhere(['like', 'user_comment', $this->user_comment]);

        return $dataProvider;
    }
}
