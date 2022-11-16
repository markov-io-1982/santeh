<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Slideshow;

/**
 * SlideshowSearch represents the model behind the search form about `backend\models\Slideshow`.
 */
class SlideshowSearch extends Slideshow
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'sort_position', 'status'], 'integer'],
            [['name_en', 'name_ru', 'name_ua', 'img', 'description_en', 'description_ru', 'description_ua', 'link_title_ua', 'link_title_en', 'link_title_ru', 'link_url', 'date_create'], 'safe'],
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
        $query = Slideshow::find();

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
            'sort_position' => $this->sort_position,
            'status' => $this->status,
            'date_create' => $this->date_create,
        ]);

        $query->andFilterWhere(['like', 'name_en', $this->name_en])
            ->andFilterWhere(['like', 'name_ru', $this->name_ru])
            ->andFilterWhere(['like', 'name_ua', $this->name_ua])
            ->andFilterWhere(['like', 'img', $this->img])
            ->andFilterWhere(['like', 'description_en', $this->description_en])
            ->andFilterWhere(['like', 'description_ru', $this->description_ru])
            ->andFilterWhere(['like', 'description_ua', $this->description_ua])
            ->andFilterWhere(['like', 'link_title_ua', $this->link_title_ua])
            ->andFilterWhere(['like', 'link_title_en', $this->link_title_en])
            ->andFilterWhere(['like', 'link_title_ru', $this->link_title_ru])
            ->andFilterWhere(['like', 'link_url', $this->link_url]);

        return $dataProvider;
    }
}
