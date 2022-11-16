<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Page;

/**
 * PageSearch represents the model behind the search form about `backend\models\Page`.
 */
class PageSearch extends Page
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['name_en', 'name_ru', 'name_ua', 'slug', 'img', 'page_body_en', 'page_body_ru', 'page_body_ua', 'seo_title_en', 'seo_title_ru', 'seo_title_ua', 'seo_description_en', 'seo_description_ru', 'seo_description_ua', 'seo_keywords_en', 'seo_keywords_ru', 'seo_keywords_ua', 'canonical_url', 'date_create', 'date_update'], 'safe'],
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
        $query = Page::find();

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
            'status' => $this->status,
            'date_create' => $this->date_create,
            'date_update' => $this->date_update,
        ]);

        $query->andFilterWhere(['like', 'name_en', $this->name_en])
            ->andFilterWhere(['like', 'name_ru', $this->name_ru])
            ->andFilterWhere(['like', 'name_ua', $this->name_ua])
            ->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'img', $this->img])
            ->andFilterWhere(['like', 'page_body_en', $this->page_body_en])
            ->andFilterWhere(['like', 'page_body_ru', $this->page_body_ru])
            ->andFilterWhere(['like', 'page_body_ua', $this->page_body_ua])
            ->andFilterWhere(['like', 'seo_title_en', $this->seo_title_en])
            ->andFilterWhere(['like', 'seo_title_ru', $this->seo_title_ru])
            ->andFilterWhere(['like', 'seo_title_ua', $this->seo_title_ua])
            ->andFilterWhere(['like', 'seo_description_en', $this->seo_description_en])
            ->andFilterWhere(['like', 'seo_description_ru', $this->seo_description_ru])
            ->andFilterWhere(['like', 'seo_description_ua', $this->seo_description_ua])
            ->andFilterWhere(['like', 'seo_keywords_en', $this->seo_keywords_en])
            ->andFilterWhere(['like', 'seo_keywords_ru', $this->seo_keywords_ru])
            ->andFilterWhere(['like', 'seo_keywords_ua', $this->seo_keywords_ua])
            ->andFilterWhere(['like', 'canonical_url', $this->canonical_url]);

        return $dataProvider;
    }
}
