<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title box-center">
        	<i class="fa fa-briefcase fa-4x" aria-hidden="true"></i>
        	<span class="label-title">Departamentos</span>
        </h3>
    </div>
    <div class="box-body box-center font-box">
	    <?php
	    if (count($model->deptEmps) > 0):
	    	foreach ($model->deptEmps as $department):
	    ?>
		    	<ul>
		    		<li><?=$department->deptNo->dept_name?></li>
		    		<li>Gestores: <?=$managers?></li>
		    	</ul>
	    <?php
	    	endforeach;
		endif;
		?>
    </div>
</div>