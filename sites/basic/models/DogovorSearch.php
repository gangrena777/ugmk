<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Dogovor;

use app\models\Region;

/**
 * DogovorSearch represents the model behind the search form of `app\models\Dogovor`.
 */
class DogovorSearch extends Dogovor
{
    /**
     * {@inheritdoc}
     */
    public $region;

    public function rules()
    {
        return [
            [['ID'], 'integer'],
            [['CODE', 'CONTRAGENT', 'GUID', 'ATTRIBUT', 'PLAN', 'PERIOD', 'NAME_NG', 'CODE_NG', 'USE_TMC', 'REGION_ID'], 'safe'],
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
        $query = Dogovor::find();

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
         $region_name = $this->REGION_ID ? $this->REGION_ID : '';

        $region = Region::find()->select('id')->where(['like', 'region_name', $region_name ]);
        // grid filtering conditions
        $query->andFilterWhere([
            'ID' => $this->ID,
            'PERIOD' => $this->PERIOD,
            'REGION_ID' => $region,
        ]);

        $query->andFilterWhere(['like', 'CODE', $this->CODE])
            ->andFilterWhere(['like', 'CONTRAGENT', $this->CONTRAGENT])
            ->andFilterWhere(['like', 'GUID', $this->GUID])
            ->andFilterWhere(['like', 'ATTRIBUT', $this->ATTRIBUT])
            ->andFilterWhere(['like', 'PLAN', $this->PLAN])
            ->andFilterWhere(['like', 'NAME_NG', $this->NAME_NG])
            ->andFilterWhere(['like', 'CODE_NG', $this->CODE_NG])
            ->andFilterWhere(['like', 'USE_TMC', $this->USE_TMC]);

        return $dataProvider;
    }
}
