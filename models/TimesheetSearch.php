<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Timesheet;

/**
 * TimesheetSearch represents the model behind the search form of `app\models\Timesheet`.
 */
class TimesheetSearch extends Timesheet
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'employee_id', 'job_id'], 'integer'],
            [['date'], 'safe'],
            [['quantity'], 'number'],
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
        $query = Timesheet::find();

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
            'employee_id' => $this->employee_id,
            'job_id' => $this->job_id,
            'date' => $this->date,
            'quantity' => $this->quantity,
        ]);

        return $dataProvider;
    }
}
