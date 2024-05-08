<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Services;

/**
 * ServiceSearch represents the model behind the search form of `app\models\Services`.
 */
class ServiceSearch extends Services
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['SERV_ID','ParentId'],'integer'],
            [['CODE', 'NAME', 'DESCRIPTION', 'isArchiv', 'isPublic',  'Path', 'GUID', 'Attribut_dogovor'], 'safe'],
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
        $query = Services::find();

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
            'SERV_ID' => $this->SERV_ID,
            'ParentId'=> $this->ParentId,
            //'Path'    => $this->Path
        ]);

        $query->andFilterWhere(['like', 'CODE', $this->CODE.'%', false])
            ->andFilterWhere(['like', 'NAME', $this->NAME])
            ->andFilterWhere(['like', 'DESCRIPTION', $this->DESCRIPTION])
            ->andFilterWhere(['like', 'isArchiv', $this->isArchiv])
            ->andFilterWhere(['like', 'isPublic', $this->isPublic])
            //->andFilterWhere(['like', 'ParentId', $this->ParentId])
            ->andFilterWhere(['like', 'Path', $this->Path.'%', false ])
            ->andFilterWhere(['like', 'GUID', $this->GUID])
            ->andFilterWhere(['like', 'Attribut_dogovor', $this->Attribut_dogovor]);

        return $dataProvider;
    }
}
