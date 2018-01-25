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
    public $department;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['emp_no'], 'integer'],
            [['birth_date', 'first_name', 'last_name', 'gender', 'hire_date', 'fullName', 'department'], 'safe'],
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

        $query = $this->searchByFullName($query);

        $query->andFilterWhere(['gender' => $this->gender])
            ->andFilterWhere(['birth_date' => $this->birth_date])
            ->andFilterWhere(['dept_emp.dept_no' => $this->department]);

        return $dataProvider;
    }

    /**
     * verifica se apenas um dos nomes foi preenchido ou se o nome completo (nome + sobrenome) foi preenchido para realizar a busca
     * @param Object $query query que está sendo construída durante a pesquisa 
     * @return Object $query nova query após verificações
     */
    public function searchByFullName($query)
    {
        $this->fullName = trim($this->fullName);
        $this->birth_date = DateHelper::toAmerican($this->birth_date);
        
        $fullName_explode = explode(" ", $this->fullName);
        $first_name = isset($fullName_explode[0])?$fullName_explode[0]:'';
        $last_name = isset($fullName_explode[1])?$fullName_explode[1]:'';;

        if ($first_name != "" && $last_name != "") {
            $query->andFilterWhere(['like', 'first_name', $first_name]);
            $query->andFilterWhere(['like', 'last_name', $last_name]);
        } else {
            $query->orFilterWhere(['like', 'first_name', $first_name]);
            $query->orFilterWhere(['like', 'last_name', $first_name]);
        }

        return $query;
    }

    /**
     * realiza a busca dos aniversariantes do dia
     * @return type
     */
    public function searchBirthday($params)
    {
        $query = Employee::find()->innerJoinWith('deptEmps');

        // add conditions that should always apply here
        $query->andFilterWhere(['MONTH(birth_date)' => date("m")]);
        $query->andFilterWhere(['DAY(birth_date)' => date("d")]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'first_name'
                ],
                'defaultOrder' => [
                    'first_name' => SORT_ASC
                ]
            ],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        return $dataProvider;
    }
}
