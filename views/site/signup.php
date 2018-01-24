<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\MaskedInput;
use kartik\select2\Select2;

?>
<div class="site-signup">

    <p>Preencha os campos abaixo para realizar o cadastro no sistema.</p>
    <?php $form = ActiveForm::begin([
        'id' => 'form-signup',
        'action' => ['signup'],
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>
    
    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'email') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'password')->passwordInput() ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'password_repeat')->passwordInput() ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Cadastre-se', [
            'class' => 'btn btn-primary', 
            'name' => 'signup-button',
            'id' => 'btn-register'
        ]) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>