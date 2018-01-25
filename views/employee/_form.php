<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\assets\EmployeeAsset;

$model->hire_date = date("d/m/Y");
$model->gender = Yii::$app->params['gender_text'][$model->gender];

EmployeeAsset::register($this);
?>

<div class="employee-form custom-tab">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    if (Yii::$app->session->hasFlash('feedback')):
    ?>
        <div class="alert alert-info alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-info"></i> Mensagem!</h4>
            <?= Yii::$app->session->getFlash('feedback'); ?>
        </div>
    <?php
    endif;
    ?>

    <?php
    if (Yii::$app->session->hasFlash('feedback_error')):
    ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-danger"></i> Mensagem!</h4>
            <?= Yii::$app->session->getFlash('feedback_error'); ?>
        </div>
    <?php
    endif;
    ?>

    <?php
    if (Yii::$app->session->hasFlash('feedback_warning')):
    ?>
        <div class="alert alert-warning alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-warning"></i> Mensagem!</h4>
            <?= Yii::$app->session->getFlash('feedback_warning'); ?>
        </div>
    <?php
    endif;
    ?>
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <?= $form->field($model, 'emp_no')->textInput(['maxlength' => true, 'disabled' => true]) ?>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4">
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

                <div class="col-lg-4 col-md-4 col-sm-4">
                    <?= $form->field($model, 'birth_date')->widget(MaskedInput::className(), [
                        'mask' => '99/99/9999',
                    ]) ?> 
                </div>

                <div class="col-lg-4 col-md-4 col-sm-4">
                    <?= $form->field($model, 'hire_date')->widget(MaskedInput::className(), [
                        'mask' => '99/99/9999',
                    ]) ?> 
                </div>
            </div>

            <div class="form-group pull-right">
                <?= Html::submitButton('Salvar', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
