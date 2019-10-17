<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\FileManage;

/**
 * FileManageSearch represents the model behind the search form of `backend\models\FileManage`.
 */
class FileManageSearch extends FileManage
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'device_id'], 'integer'],
            [['raw_name', 'unique_name', 'detail', 'created_at', 'updated_at'], 'safe'],
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
        $query = FileManage::find();

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
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'raw_name', $this->raw_name])
            ->andFilterWhere(['like', 'unique_name', $this->unique_name])
            ->andFilterWhere(['like', 'detail', $this->detail]);

        return $dataProvider;
    }
}
