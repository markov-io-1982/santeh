<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Category;

/**
 * CategorySearch represents the model behind the search form about `backend\models\Category`.
 */
class CategorySearch extends Category
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'parent_id', 'sort_position', 'status'], 'integer'],
            [['name_en', 'name_ru', 'name_ua', 'slug', 'seo_title_en', 'seo_title_ru', 'seo_title_ua', 'seo_description_en', 'seo_description_ru', 'seo_description_ua', 'seo_keywords_en', 'seo_keywords_ru', 'seo_keywords_ua', 'date_create', 'date_update'], 'safe'],
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
        $query = Category::find();

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
            'parent_id' => $this->parent_id,
            'sort_position' => $this->sort_position,
            'date_create' => $this->date_create,
            'date_update' => $this->date_update,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'name_en', $this->name_en])
            ->andFilterWhere(['like', 'name_ru', $this->name_ru])
            ->andFilterWhere(['like', 'name_ua', $this->name_ua])
            ->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'seo_title_en', $this->seo_title_en])
            ->andFilterWhere(['like', 'seo_title_ru', $this->seo_title_ru])
            ->andFilterWhere(['like', 'seo_title_ua', $this->seo_title_ua])
            ->andFilterWhere(['like', 'seo_description_en', $this->seo_description_en])
            ->andFilterWhere(['like', 'seo_description_ru', $this->seo_description_ru])
            ->andFilterWhere(['like', 'seo_description_ua', $this->seo_description_ua])
            ->andFilterWhere(['like', 'seo_keywords_en', $this->seo_keywords_en])
            ->andFilterWhere(['like', 'seo_keywords_ru', $this->seo_keywords_ru])
            ->andFilterWhere(['like', 'seo_keywords_ua', $this->seo_keywords_ua]);

        return $dataProvider;
    }
}
