<?php

use yii\grid\GridView;

?>
<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">
        	Aniversariantes do dia
        </h3>
    </div>
    <div class="box-body">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'options' => ['class' => 'table-responsive'],
            'columns' => [

                'fullName',
                'gender',
                'birth_date',
                [
                	'class' => 'yii\grid\ActionColumn',
                	'template' => '{view}'
                ],
            ],
        ]); ?>
    </div>
</div>