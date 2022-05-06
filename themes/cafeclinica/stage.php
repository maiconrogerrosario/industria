<?php $v->layout("_theme"); ?>

<div class="app-main">
	<div class="row">
		<div class="col-md-12">
			<div class="btn-group pull-right">
				<!--<div class="btn-group pull-right">
					<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-download"></i> Descargar <span class="caret"></span>
					</button>
					<ul class="dropdown-menu" role="menu">
						<li><a href="report/clients-word.php">Word 2007 (.docx)</a></li>
					</ul>
				</div>-->
			</div>
			<div class="container-fluid p-t-15">
				<div class="box">
					<header>
						<h3>Fornecedores</h3>
						<div class="box-tools">
						</div>
					</header>
				</div>
				
				<a href="<?= url("/work/stage-add"); ?>" class="btn btn-primary"><i class='fa fa-fw fa-male'></i>Nova Obra ou Serviço</a>
				<br><br>
				
			<div class="card-content table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
						<th scope="col" style="text-align:center;font-size:12px;">DESCRIÇÃO</th>
						<th scope="col" style="text-align:center;font-size:12px;">DATA DE INÍCIO</th>
						<th scope="col" style="text-align:center;font-size:12px;">PRAZO</th>
						<th scope="col" style="text-align:center;font-size:12px;">DATA FINAL</th>
						<th scope="col" style="text-align:center;font-size:12px;">STATUS</th>
						<th scope="col" style="text-align:center;font-size:12px;">AÇÕES</th>
					</thead>
					<?php if (!empty($stages)): ?>
						<?php foreach ($stages as $stage):?>
					    <?php 	$stageCategory  = $stage->getStageCategory();?>
					<thead>
						<th>
							<th scope="col" style="text-align:center;font-size:12px;"><?php echo $stageCategory->name;?></th>
							<th scope="col" style="text-align:center;font-size:12px;"><?php echo $stage->date_initial;?></th>
							<th scope="col" style="text-align:center;font-size:12px;"><?php echo $stage->date_final;?></th>
							<th scope="col" style="text-align:center;font-size:12px;">
							<a href="<?= url("/work/supplier-edit/{$supplier->id}"); ?>" class="btn btn-warning btn-xs">Editar</a>
							<a class="btn-simple btn btn-danger btn-xs" title="" href="#"
                                   data-post="<?= url("/work/supplier"); ?>"
                                   data-action="delete"
                                   data-confirm="Tem Certeza que Deseja Deletar esse Fornecedor?"
                                   data-id="<?= $supplier->id; ?>">Deletar</a>  
							</th>
						</th>
					 
					</thead>
					
					<tbody>
					<?php if (!empty($teste)): ?>
						<?php foreach ($teste as $stage):?>
					    <?php 	$stageCategory  = $stage->getStageCategory();?>
						<tr>
							<td scope="col" style="text-align:center;font-size:12px;"><?php echo $stageCategory->name;?></td>
							<td scope="col" style="text-align:center;font-size:12px;"><?php echo $stage->date_initial;?></td>
							<td scope="col" style="text-align:center;font-size:12px;"><?php echo $stage->date_final;?></td>
							<td scope="col" style="text-align:center;font-size:12px;">
							<a href="<?= url("/work/supplier-edit/{$supplier->id}"); ?>" class="btn btn-warning btn-xs">Editar</a>
							<a class="btn-simple btn btn-danger btn-xs" title="" href="#"
                                   data-post="<?= url("/work/supplier"); ?>"
                                   data-action="delete"
                                   data-confirm="Tem Certeza que Deseja Deletar esse Fornecedor?"
                                   data-id="<?= $supplier->id; ?>">Deletar</a>  
							</td>
						</tr>
						<?php endforeach; ?>
					 <?php endif; ?>	
					</tbody>
					<?php endforeach; ?>
					<?php endif; ?>	
					
				</table>			
			</div>
			</div>	
		</div>
	</div>
</div>



		


		


		


		

