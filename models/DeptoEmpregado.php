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
        ];
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
