<?php

use yii\helpers\Html;
use yii\bootstrap\Tabs;

$this->title = 'Atualizar colaborador: '.$model->fullName ;
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
                ],
                [
                    'label' => Yii::t('app', 'Departamentos'),
                    'content' => $this->render('create-departments', [
                    	'model' => $model
                    ])
                ],
                [
                    'label' => Yii::t('app', 'Títulos'),
                    'content' => $this->render('create-title', [
                        'model' => $model
                    ])
                ],
            ],
        ]);
    ?>

</div>
