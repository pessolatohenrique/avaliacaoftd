<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Employee;
use app\models\DeptoEmpregado;
use app\components\DateHelper;

/**
 * EmployeeSearch represents the model behind the search form of `app\models\Employee`.
 */
class EmployeeSearch extends Employee
{
    public $fullName;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['emp_no'], 'integer'],
            [['birth_date', 'first_name', 'last_name', 'gender', 'hire_date', 'fullName'], 'safe'],
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
        $query = Employee::find()->innerJoinWith('deptEmps');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'first_name'
                ],
                'defaultOrder' => [
                    'first_name' => SORT_ASC
                ]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $this->fullName = trim($this->fullName);
        $this->birth_date = DateHelper::toAmerican($this->birth_date);

        $query->orFilterWhere(['like', 'first_name', $this->fullName])
            ->orFilterWhere(['like', 'last_name', $this->fullName])
            ->andFilterWhere(['gender' => $this->gender])
            ->andFilterWhere(['birth_date' => $this->birth_date]);

        return $dataProvider;
    }
}
