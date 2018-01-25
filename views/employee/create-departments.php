<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\Department;

$departments = Department::find()->all();
?>

<div class="employee-form custom-tab">
	<div class="box box-primary">
		<div class="box-body">
		    <?php $form = ActiveForm::begin([
		    	'action' => ['create-departments']
		    ]); ?>

		    <table class="table table-striped table-bordered table-append" id="tabela-departamento">
		    	<thead>
		    		<th>Atual?</th>
		    		<th>Departamento</th>
		    		<th>Data Inicial</th>
		    		<th>Data Final</th>
		    		<th></th>
		    	</thead>
		    	<tbody>
		    		<tr>
		    			<td>
		    				<input type="checkbox" class="actual_job">
		    				<input type="hidden" name="emp_no" value="<?=$model->emp_no?>">
		    			</td>
		    			<td>   

		    				<?= $form->field($model, 'department_create[]')
		    					->dropDownList(
		    						ArrayHelper::map($departments, 'dept_no', 'dept_name'),
		    						[
			    						'options' =>
			    						[
			    							'class' => 'form-control'
			    						]
		    						]
		    					)->label(false)
      						?>
	    				</td>
	    				<td>
				            <?= $form->field($model, 'department_from[]')
				            ->textInput(['class' => 'initial_date form-control'])
				            ->label(false) ?>
	    				</td>
	    				<td>
				            <?= $form->field($model, 'department_to[]')
				            ->textInput(['class' => 'final_date form-control'])
				            ->label(false) ?>   
	    				</td>
	    				<td>
	    					<a href="#" class="add-line" data-target="tabela-departamento">
	    						<i class="fa fa-plus-circle" aria-hidden="true"></i>
	    					</a>
	    					<a href="#" class="remove-line">
	    						<i class="fa fa-trash" aria-hidden="true"></i>
	    					</a>
	    				</td>
		    		</tr>
		    	</tbody>
		    </table>
		    <div class="form-group pull-right">
		        <?= Html::submitButton('Salvar', ['class' => 'btn btn-success']) ?>
		    </div>

		    <?php ActiveForm::end(); ?>
		</div>
	</div>

</div>
