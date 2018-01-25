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
		    	'action' => ['create-title']
		    ]); ?>

		    <table class="table table-striped table-bordered table-append" id="tabela-titulo">
		    	<thead>
		    		<th>Atual?</th>
		    		<th>Título</th>
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

		    				<?= $form->field($model, 'title_create[]')
		    					->label(false)
      						?>
	    				</td>
	    				<td>
				            <?= $form->field($model, 'title_from[]')
				            ->textInput(['class' => 'initial_date form-control'])
				            ->label(false) ?>
	    				</td>
	    				<td>
				            <?= $form->field($model, 'title_to[]')
				            ->textInput(['class' => 'final_date form-control'])
				            ->label(false) ?>   
	    				</td>
	    				<td>
	    					<a href="#" class="add-line" data-target="tabela-titulo">
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
