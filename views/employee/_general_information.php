<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title box-center">
        	<i class="fa fa-book fa-4x" aria-hidden="true"></i><br>
        	<span class="label-title">Informações de Cadastro</span>
        </h3>
    </div>
    <div class="box-body box-center font-box">
    	<ul>
    		<li>
    			Gênero: 
    			<?=$model->gender != ""?$model->gender:"Não informado"?>		
			</li>
    		<li>
    			Data de aniversário: 
    			<?=$model->birth_date != ""?$model->birth_date:"Não informado"?>
    		</li>
    		<li>
    			Data de contratação: 
    			<?=$model->hire_date != ""?$model->hire_date:"Não informado"?>
    		</li>
    	</ul>
    </div>
</div>