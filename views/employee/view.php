<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Employee */

$this->title = $model->fullName;
$this->params['breadcrumbs'][] = ['label' => 'Colaboradores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
// var_dump($model->deptEmps[0]->deptNo->dept_name);
?>
<div class="employee-view">
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-6">
            <?=$this->render('_general_information', [
                'model' => $model
            ])?>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-6">
            <?=$this->render('_departments', [
                'model' => $model,
                'managers' => $managers
            ])?>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-6">
            <?=$this->render('_titles', [
                'model' => $model
            ])?>
        </div>
    </div>

</div>


