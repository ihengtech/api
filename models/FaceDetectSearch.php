<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\FaceDetect;

/**
 * FaceDetectSearch represents the model behind the search form of `backend\models\FaceDetect`.
 */
class FaceDetectSearch extends FaceDetect
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'device_id', 'file_manage_id'], 'integer'],
            [['created_at', 'analysis_result'], 'safe'],
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
        $query = FaceDetect::find();

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
            'device_id' => $this->device_id,
            'file_manage_id' => $this->file_manage_id,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'analysis_result', $this->analysis_result]);

        return $dataProvider;
    }
}
