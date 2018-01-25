<?php

namespace app\models;

use Yii;
use app\components\DateHelper;

/**
 * This is the model class for table "dept_emp".
 *
 * @property int $emp_no
 * @property string $dept_no
 * @property string $from_date
 * @property string $to_date
 *
 * @property Employee $empNo
 * @property Department $deptNo
 */
class DeptoEmpregado extends \yii\db\ActiveRecord
{
    public $total_group; //atributo que armazena total agrupado
    public $dept_group_name; //atributo que armazena nome agrupado
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dept_emp';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['emp_no', 'dept_no', 'from_date', 'to_date'], 'required'],
            [['emp_no'], 'integer'],
            [['from_date', 'to_date'], 'safe'],
            [['dept_no'], 'string', 'max' => 4]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'emp_no' => 'Emp No',
            'dept_no' => 'Dept No',
            'from_date' => 'From Date',
            'to_date' => 'To Date',
            'total_group' => 'Total'
        ];
    }

    /**
     * mostra o total de funcionários por departamento
     * @return Array $total_group total de funcionários por departamento
     */
    public function groupByDepartment()
    {
        $total_group = self::find()
        ->select(['*', 'COUNT(*) AS total_group', 'dept_name AS dept_group_name'])
        ->joinWith('deptNo')
        ->groupBy(['dept_emp.dept_no'])
        ->orderBy('departments.dept_name','ASC')
        ->all();
    
        return $total_group;
    }

    /**
     * realiza agrupamento para gerar um gráfico
     * @param Array $department_employee resultado encontrado na pesquisa
     * @return Array $chart array com dados para gráfico
     */
    public function prepareChart($department_employee)
    {
        $chart = array();

        foreach ($department_employee as $department) {
            $array_tmp = array();
            $array_tmp['name'] = $department->dept_group_name;
            $array_tmp['data'] = array(intval($department->total_group));
            array_push($chart, $array_tmp);
        }

        return $chart;
    }

    /**
     * realiza a exclusão de relações existentes entre departamentos e colaboradores
     * o objetivo é realizar uma exclusão e depois inserção na tabela que possui essa relação
     * @param Integer $emp_no ID buscado 
     * @return boolean delete flag informando se excluiu ou não
     */
    public function deleteRelation($emp_no)
    {
        $relations  = DeptoEmpregado::find()->where(['emp_no' => $emp_no])->all();

        foreach ($relations as $key => $relation) {
             $relation->delete();
        }
    }
    
    /**
     * realiza a inserção na tabela dept_emp em lote
     * ou seja, recebe um array e preenche a tabela com vários registros de acordo com este array
     * @param Array $params lista com parâmetros 
     * @return boolean $inseriu flag dizendo se inseriu ou não
     */
    public function insertBatch($params)
    {
        $employee = $params['Employee'];
        $department = $employee['department_create'];
        $array_save = array();

        for ($i =0; $i < count($department); $i++) {
            $array_tmp = array();
            $array_tmp[0] = $params['emp_no'];
            $array_tmp[1] = $employee['department_create'][$i];
            
            if ($employee['department_from'][$i] != "") {
                $array_tmp[2] = DateHelper::toAmerican($employee['department_from'][$i]);
            } else {
                $array_tmp[2] = date("Y-m-d");
            }
           
            if ($employee['department_to'][$i] != "") {
                $array_tmp[3] = DateHelper::toAmerican($employee['department_to'][$i]);
            } else {
                $array_tmp[3] = date("Y-m-d");
            }
            
            array_push($array_save, $array_tmp);
        }   

        $inseriu = Yii::$app->db->createCommand()->batchInsert(
            'dept_emp', 
            ['emp_no', 'dept_no', 'from_date', 'to_date'], 
            $array_save
        )->execute();

        return $inseriu;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpNo()
    {
        return $this->hasOne(Employee::className(), ['emp_no' => 'emp_no']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeptNo()
    {
        return $this->hasOne(Department::className(), ['dept_no' => 'dept_no']);
    }
}
