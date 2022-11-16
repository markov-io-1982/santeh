<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ProductCombination;

/**
 * ProductCombinationSearch represents the model behind the search form about `backend\models\ProductCombination`.
 */
class ProductCombinationSearch extends ProductCombination
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'quantity', 'reserve', 'status', 'parent_id', 'sort_position', 'attribute_id', 'attribute_value_id', 'buy'], 'integer'],
            [['img', 'date_create'], 'safe'],
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
        $query = ProductCombination::find();

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
            'quantity' => $this->quantity,
            'reserve' => $this->reserve,
            'date_create' => $this->date_create,
            'status' => $this->status,
            'parent_id' => $this->parent_id,
            'sort_position' => $this->sort_position,
            'attribute_id' => $this->attribute_id,
            'attribute_value_id' => $this->attribute_value_id,
            'buy' => $this->buy,
        ]);

        $query->andFilterWhere(['like', 'img', $this->img]);

        return $dataProvider;
    }
}
