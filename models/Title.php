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
     * @return \yii\db\ActiveQuery
     */
    public function getEmpNo()
    {
        return $this->hasOne(Employees::className(), ['emp_no' => 'emp_no']);
    }
}
