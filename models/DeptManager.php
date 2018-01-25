<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dept_manager".
 *
 * @property int $emp_no
 * @property string $dept_no
 * @property string $from_date
 * @property string $to_date
 *
 * @property Employees $empNo
 * @property Departments $deptNo
 */
class DeptManager extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dept_manager';
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
            [['dept_no'], 'string', 'max' => 4],
            [['emp_no', 'dept_no'], 'unique', 'targetAttribute' => ['emp_no', 'dept_no']],
            [['emp_no'], 'exist', 'skipOnError' => true, 'targetClass' => Employees::className(), 'targetAttribute' => ['emp_no' => 'emp_no']],
            [['dept_no'], 'exist', 'skipOnError' => true, 'targetClass' => Departments::className(), 'targetAttribute' => ['dept_no' => 'dept_no']],
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
        return $this->hasOne(Departments::className(), ['dept_no' => 'dept_no']);
    }
}
