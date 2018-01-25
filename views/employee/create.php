<?php

use yii\helpers\Html;
use yii\bootstrap\Tabs;

$this->title = 'Adicionar novo colaborador';
$this->params['breadcrumbs'][] = ['label' => 'Colaboradores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="employee-create">
    <?php
        echo Tabs::widget([
            'items' => [
                [
                    'label' => Yii::t('app', 'Informações Gerais'),
                    'content' => $this->render('_form', [
                    	'model' => $model                    
                    ]),
                    'active' => true
                ]
            ],
        ]);
    ?>

</div>
