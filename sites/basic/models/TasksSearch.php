<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Tasks;
use app\models\Region;

/**
 * TasksSearch represents the model behind the search form of `app\models\Tasks`.
 */
class TasksSearch extends Tasks
{
    /**
     * {@inheritdoc}
     */
    public $region;

    public function rules()
    {
        return [
            [['id', 'task_id', 'journal_id'], 'integer'],
            [['dogovor_code', 'task_name', 'date_create','region_id'], 'safe'],

        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Tasks::find();
        

       
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

        $region_name = $this->region_id ? $this->region_id : '';

        $region = Region::find()->select('id')->where(['like', 'region_name', $region_name ]);

        //$regionId = $region ? $region : '';

       // echo $region;

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
             //'region_id' => $this->region_id,
            'region_id' => $region,
            'task_id' => $this->task_id,
            'journal_id' => $this->journal_id,
            'date_create' => $this->date_create,
        ]);

        $query->andFilterWhere(['like', 'dogovor_code', $this->dogovor_code])
            ->andFilterWhere(['like', 'task_name', $this->task_name]);

        return $dataProvider;

    }
}
