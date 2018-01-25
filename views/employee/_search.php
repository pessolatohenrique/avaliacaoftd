<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
use kartik\select2\Select2;

?>

<div class="employee-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-12">
            <?= $form->field($model, 'fullName') ?>
        </div> 

        <div class="col-lg-4 col-md-4 col-sm-6">
            <?=$form->field($model, 'gender')->widget(Select2::classname(), [
                'data' => Yii::$app->params['gender'],
                'options' => [
                    'placeholder' => 'Selecione o gênero'
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
                'theme' => Select2::THEME_DEFAULT,
            ]);?>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-6">
            <?= $form->field($model, 'birth_date')->widget(MaskedInput::className(), [
                'mask' => '99/99/9999',
            ]) ?>   
        </div>  
    </div>

    <div class="form-group">
        <?= Html::submitButton('Pesquisar', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Novo Colaborador', ['create'], ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
