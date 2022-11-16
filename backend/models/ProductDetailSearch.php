<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ProductDetail;

/**
 * ProductDetailSearch represents the model behind the search form about `backend\models\ProductDetail`.
 */
class ProductDetailSearch extends ProductDetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'product_id', 'buy', 'count_views'], 'integer'],
            [['description_en', 'description_ru', 'description_ua', 'complectation_en', 'complectation_ru', 'complectation_ua', 'seo_title_en', 'seo_title_ru', 'seo_title_ua', 'seo_description_en', 'seo_description_ru', 'seo_description_ua', 'seo_keywords_en', 'seo_keywords_ru', 'seo_keywords_ua', 'seo_canonical_url'], 'safe'],
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
        $query = ProductDetail::find();

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
            'product_id' => $this->product_id,
            'buy' => $this->buy,
            'count_views' => $this->count_views,
        ]);

        $query->andFilterWhere(['like', 'description_en', $this->description_en])
            ->andFilterWhere(['like', 'description_ru', $this->description_ru])
            ->andFilterWhere(['like', 'description_ua', $this->description_ua])
            ->andFilterWhere(['like', 'complectation_en', $this->complectation_en])
            ->andFilterWhere(['like', 'complectation_ru', $this->complectation_ru])
            ->andFilterWhere(['like', 'complectation_ua', $this->complectation_ua])
            ->andFilterWhere(['like', 'seo_title_en', $this->seo_title_en])
            ->andFilterWhere(['like', 'seo_title_ru', $this->seo_title_ru])
            ->andFilterWhere(['like', 'seo_title_ua', $this->seo_title_ua])
            ->andFilterWhere(['like', 'seo_description_en', $this->seo_description_en])
            ->andFilterWhere(['like', 'seo_description_ru', $this->seo_description_ru])
            ->andFilterWhere(['like', 'seo_description_ua', $this->seo_description_ua])
            ->andFilterWhere(['like', 'seo_keywords_en', $this->seo_keywords_en])
            ->andFilterWhere(['like', 'seo_keywords_ru', $this->seo_keywords_ru])
            ->andFilterWhere(['like', 'seo_keywords_ua', $this->seo_keywords_ua])
            ->andFilterWhere(['like', 'seo_canonical_url', $this->seo_canonical_url]);

        return $dataProvider;
    }
}
