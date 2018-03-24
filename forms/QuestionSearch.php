<?php
namespace abdualiym\vote\forms;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use abdualiym\vote\entities\Question;
/**
 *
 * SlideSearch represents the model behind the search form about `abdualiym\slider\entities\Slide`.
 */
class QuestionSearch extends Question {
    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'type', 'status'], 'integer'],
        ];
    }
    /**
     * @inheritdoc
     */
    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }
    /**
     * Creates data provider instance with search query applied
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params) {
        $query = Question::find();
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
            'type' => $this->type,
            'status' => $this->status,
        ]);
        return $dataProvider;
    }
}
