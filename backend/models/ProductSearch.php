<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Product;

/**
 * ProductSearch represents the model behind the search form about `backend\models\Product`.
 */
class ProductSearch extends Product
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'sort_position', 'quantity', 'min_order', 'reserve', 'promo_status_id', 'stock_status_id', 'on_main', 'status'], 'integer'],
            [['name_en', 'name_ru', 'name_ua', 'intro_text_en', 'intro_text_ru', 'intro_text_ua', 'promo_date_end', 'img', 'slug', 'date_create', 'date_update','kode'], 'safe'],
            [['price', 'price_old'], 'number'],
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
        $query = Product::find();

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
            'category_id' => $this->category_id,
            'sort_position' => $this->sort_position,
            'price' => $this->price,
            'price_old' => $this->price_old,
            'quantity' => $this->quantity,
            'min_order' => $this->min_order,
            'reserve' => $this->reserve,
            'promo_status_id' => $this->promo_status_id,
            'promo_date_end' => $this->promo_date_end,
            'stock_status_id' => $this->stock_status_id,
            'on_main' => $this->on_main,
            'status' => $this->status,
            'date_create' => $this->date_create,
            'date_update' => $this->date_update,
            'kode' => $this->kode,
        ]);

        $query->andFilterWhere(['like', 'name_en', $this->name_en])
            ->andFilterWhere(['like', 'name_ru', $this->name_ru])
            ->andFilterWhere(['like', 'name_ua', $this->name_ua])
            ->andFilterWhere(['like', 'intro_text_en', $this->intro_text_en])
            ->andFilterWhere(['like', 'intro_text_ru', $this->intro_text_ru])
            ->andFilterWhere(['like', 'intro_text_ua', $this->intro_text_ua])
            ->andFilterWhere(['like', 'img', $this->img])
            ->andFilterWhere(['like', 'slug', $this->slug]);

        return $dataProvider;
    }
}
