<?php

namespace app\models;

use Yii;
use app\components\DateHelper;

/**
 * This is the model class for table "titles".
 *
 * @property int $emp_no
 * @property string $title
 * @property string $from_date
 * @property string $to_date
 *
 * @property Employees $empNo
 */
class Title extends \yii\db\ActiveRecord
{
    const ACTUAL_TITLE = "9999-01-01";
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'titles';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['emp_no', 'title', 'from_date'], 'required'],
            [['emp_no'], 'integer'],
            [['from_date', 'to_date'], 'safe'],
            [['title'], 'string', 'max' => 50],
            [['emp_no', 'title', 'from_date'], 'unique', 'targetAttribute' => ['emp_no', 'title', 'from_date']],
            [['emp_no'], 'exist', 'skipOnError' => true, 'targetClass' => Employees::className(), 'targetAttribute' => ['emp_no' => 'emp_no']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'emp_no' => 'Emp No',
            'title' => 'Title',
            'from_date' => 'From Date',
            'to_date' => 'To Date',
        ];
    }

    public function afterFind()
    {
        $this->from_date = DateHelper::toBrazilian($this->from_date);

        if ($this->to_date == self::ACTUAL_TITLE) {
            $this->to_date = "Título atual";
        } else {
            $this->to_date = DateHelper::toBrazilian($this->to_date);
        }

    }

    /**
     * realiza a exclusão de títulos de um usuário, de modo a permitir adicionar novos
     * feito desta maneira pela estrutura de tabela dinâmica
     * @param Integer $emp_no ID do colaborador 
     * @return boolean $excluiu flag informando se exclusão ocorreu
     */
    public function deleteRelation($emp_no) {
        $titulos = self::find()->where(['emp_no' => $emp_no])->all();
        
        foreach ($titulos as $titulo) {
            $titulo->delete();
        }

        return 1;
    }

    /**
     * realiza a inserção na tabela titles em lote
     * ou seja, recebe um array e preenche a tabela com vários registros de acordo com este array
     * @param Array $params lista com parâmetros 
     * @return boolean $inseriu flag dizendo se inseriu ou não
     */
    public function insertBatch($params)
    {
        $employee = $params['Employee'];
        $department = $employee['title_create'];
        $array_save = array();

        for ($i =0; $i < count($department); $i++) {
            $array_tmp = array();
            $array_tmp[0] = $params['emp_no'];
            $array_tmp[1] = $employee['title_create'][$i];
            
            if ($employee['title_from'][$i] != "") {
                $array_tmp[2] = DateHelper::toAmerican($employee['title_from'][$i]);
            } else {
                $array_tmp[2] = date("Y-m-d");
            }
           
            if ($employee['title_to'][$i] != "") {
                $array_tmp[3] = DateHelper::toAmerican($employee['title_to'][$i]);
            } else {
                $array_tmp[3] = date("Y-m-d");
            }
            
            array_push($array_save, $array_tmp);
        }   

        $inseriu = Yii::$app->db->createCommand()->batchInsert(
            'titles', 
            ['emp_no', 'title', 'from_date', 'to_date'], 
            $array_save
        )->execute();

        return $inseriu;
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpNo()
    {
        return $this->hasOne(Employees::className(), ['emp_no' => 'emp_no']);
    }
}
