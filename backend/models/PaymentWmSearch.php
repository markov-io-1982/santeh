<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\PaymentWm;

/**
 * PaymentWmSearch represents the model behind the search form about `backend\models\PaymentWm`.
 */
class PaymentWmSearch extends PaymentWm
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'order_id', 'mode', 'status'], 'integer'],
            [['user_id', 'amt', 'details', 'payee_purse', 'payment_no', 'payment_amount', 'sys_invs_no', 'sys_trans_no', 'sys_trans_date', 'payer_purse', 'payer_wm', 'date_create', 'phone', 'note'], 'safe'],
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
        $query = PaymentWm::find();

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
            'mode' => $this->mode,
            'sys_trans_date' => $this->sys_trans_date,
            'date_create' => $this->date_create,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'user_id', $this->user_id])
            ->andFilterWhere(['like', 'amt', $this->amt])
            ->andFilterWhere(['like', 'details', $this->details])
            ->andFilterWhere(['like', 'payee_purse', $this->payee_purse])
            ->andFilterWhere(['like', 'payment_no', $this->payment_no])
            ->andFilterWhere(['like', 'payment_amount', $this->payment_amount])
            ->andFilterWhere(['like', 'sys_invs_no', $this->sys_invs_no])
            ->andFilterWhere(['like', 'sys_trans_no', $this->sys_trans_no])
            ->andFilterWhere(['like', 'payer_purse', $this->payer_purse])
            ->andFilterWhere(['like', 'payer_wm', $this->payer_wm])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }
}
