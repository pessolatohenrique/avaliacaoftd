<?php

use yii\grid\GridView;

?>
<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">
        	Número de colaboradores por departamento
        </h3>
    </div>
    <div class="box-body">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'options' => ['class' => 'table-responsive'],
            'columns' => [
                [
                    'attribute' => 'deptNo.dept_name',
                    'label' => 'Departamento'
                ],
                'total_group',
            ],
        ]); ?>
    </div>
</div>