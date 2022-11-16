<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\PaymentPb;

/**
 * PaymentPbSearch represents the model behind the search form about `backend\models\PaymentPb`.
 */
class PaymentPbSearch extends PaymentPb
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'order_id'], 'integer'],
            [['amt', 'amt_total', 'ccy', 'merchant', 'order', 'details', 'ext_details', 'pay_way', 'state', 'ref', 'note', 'sender_phone', 'pay_status', 'date_create', 'date_update'], 'safe'],
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
        $query = PaymentPb::find();

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
            'order_id' => $this->order_id,
            'date_create' => $this->date_create,
            'date_update' => $this->date_update,
        ]);

        $query->andFilterWhere(['like', 'amt', $this->amt])
            ->andFilterWhere(['like', 'amt_total', $this->amt_total])
            ->andFilterWhere(['like', 'ccy', $this->ccy])
            ->andFilterWhere(['like', 'merchant', $this->merchant])
            ->andFilterWhere(['like', 'order', $this->order])
            ->andFilterWhere(['like', 'details', $this->details])
            ->andFilterWhere(['like', 'ext_details', $this->ext_details])
            ->andFilterWhere(['like', 'pay_way', $this->pay_way])
            ->andFilterWhere(['like', 'state', $this->state])
            ->andFilterWhere(['like', 'ref', $this->ref])
            ->andFilterWhere(['like', 'note', $this->note])
            ->andFilterWhere(['like', 'sender_phone', $this->sender_phone])
            ->andFilterWhere(['like', 'pay_status', $this->pay_status]);

        return $dataProvider;
    }
}
