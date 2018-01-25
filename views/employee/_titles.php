<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title box-center">
        	<i class="fa fa-id-card fa-4x" aria-hidden="true"></i><br>
        	<span class="label-title">Títulos Exercidos</span>
        </h3>
    </div>
    <div class="box-body box-center font-box">
    	<ul>
            <?php 
            if (count($model->titles) > 0):
                foreach ($model->titles as $title_search):
            ?>
        		<li class="list-space">
        			<?=$title_search->title != ""?$title_search->title:"Não informado"?><br>
                    Iniciou em: <?=$title_search->from_date != ""?$title_search->from_date:"Não informado"?>	
                    <br>
                    Finalizou em: <?=$title_search->to_date != ""?$title_search->to_date:"Não informado"?>
    			</li>
            <?php
                endforeach;
            endif;
            ?>
    	</ul>
    </div>
</div>