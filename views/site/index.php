<?php

$this->title = 'Dashboard';

?>

<div class="site-index">

    <div class="row">
        <div class="col-md-12">
            <?=$this->render('_department-chart', [
                'dataProvider' => $departmentProvider,
                'departmentChart' => $departmentChart
            ])?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12">
            <?=$this->render('_departments', [
                'dataProvider' => $departmentProvider
             ])?>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12">
            <?=$this->render('_birthday', [
                'dataProvider' => $dataProvider
             ])?>
        </div>
    </div>


</div>
