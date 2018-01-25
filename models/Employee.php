<?php

namespace app\models;

use Yii;
use app\components\DateHelper;

/**
 * This is the model class for table "employees".
 *
 * @property int $emp_no
 * @property string $birth_date
 * @property string $first_name
 * @property string $last_name
 * @property string $gender
 * @property string $hire_date
 *
 * @property DeptEmp[] $deptEmps
 * @property Departments[] $deptNos
 * @property DeptManager[] $deptManagers
 * @property Departments[] $deptNos0
 * @property Salaries[] $salaries
 * @property Titles[] $titles
 */
class Employee extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'employees';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['emp_no', 'birth_date', 'first_name', 'last_name', 'gender', 'hire_date'], 'required'],
            [['emp_no'], 'integer'],
            [['birth_date', 'hire_date'], 'safe'],
            [['gender'], 'string'],
            [['first_name'], 'string', 'max' => 14],
            [['last_name'], 'string', 'max' => 16],
            [['emp_no'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'emp_no' => 'Emp No',
            'birth_date' => 'Aniversário',
            'first_name' => 'Primeiro Nome',
            'last_name' => 'Último Nome',
            'gender' => 'Gênero',
            'hire_date' => 'Data de Contrataão',
            'fullName' => 'Nome completo'
        ];
    }

    /**
     * este método será chamado em toda a busca realizada
     * ou seja, após encontrar um ou mais empregados, o método age automaticamente
     * @return type
     */
    public function afterFind()
    {
        $this->birth_date = DateHelper::toBrazilian($this->birth_date);
        $this->hire_date = DateHelper::toBrazilian($this->hire_date);
        $this->gender = Yii::$app->params['gender'][$this->gender];
    }

    /**
     * obtém a lista de gestores de um departamento no qual o funcionário pesquisado trabalha
     * @return String lista dos gestores encontrados
     */
    public function getManagers()
    {
        $strManager = "";

        foreach ($this->deptEmps as $department) {
            $managers_search = $department->deptNo->deptManagers;
            foreach ($managers_search as $manager) {
                $strManager .= $manager->empNo->fullName.", ";
            }
        }
        $strManager = substr(trim($strManager), 0, -1);
        
        return $strManager;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeptEmps()
    {
        return $this->hasMany(DeptoEmpregado::className(), ['emp_no' => 'emp_no']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeptNos()
    {
        return $this->hasMany(Departments::className(), ['dept_no' => 'dept_no'])->viaTable('dept_emp', ['emp_no' => 'emp_no']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeptManagers()
    {
        return $this->hasMany(DeptManager::className(), ['emp_no' => 'emp_no']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeptNos0()
    {
        return $this->hasMany(Departments::className(), ['dept_no' => 'dept_no'])->viaTable('dept_manager', ['emp_no' => 'emp_no']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSalaries()
    {
        return $this->hasMany(Salaries::className(), ['emp_no' => 'emp_no']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTitles()
    {
        return $this->hasMany(Title::className(), ['emp_no' => 'emp_no']);
    }

    /**
     * obtém o nome completo do funcionário
     * @return void
     */
    public function getFullName()
    {
        return $this->first_name." ".$this->last_name;
    }
}
