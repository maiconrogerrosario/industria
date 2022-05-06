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
						<h3>Funcionários</h3>
						<div class="box-tools">
						</div>
					</header>
				</div>
				
			<div class="card-content table-responsive">
				<a href="<?= url("/app/employee-add"); ?>" class="btn btn-primary"><i class='fa fa-fw fa-male'></i>Novo Funcinário</a>
				<br><br>

				<table class="table table-bordered table-hover">
					<thead>
						<th>Nome do Funcinário</th>
						<th>Função</th>
						<th>Email</th>
						<th>Celular</th>
						<th>Ações</th>
					</thead>
					<tbody>
					
					<?php if (!empty($employees)): ?>
						<?php foreach ($employees as $employee):?>
						<?php 	$ocupation  = $employee->getOccupation();?>

						<tr>
							<td><?php echo $employee->name;?></td>
							<td><?php echo $ocupation->name; ?></td>
							<td><?php echo $employee->email; ?></td>
							<td><?php echo $employee->mobile; ?></td>
							<td style="width:280px;">
							<a href="<?= url("/app/employee-edit/{$employee->id}"); ?>" class="btn btn-warning btn-xs">Editar</a>
							<a class="btn btn-danger btn-xs" title="" href="#"
                                   data-post="<?= url("/app/employee"); ?>"
                                   data-action="delete"
                                   data-confirm="Tem certeza que deseja deletar esse Funcionário?"
                                   data-id="<?= $employee->id; ?>">Deletar</a>
						
						
							</td>
						</tr>
						<?php endforeach; ?>
					<?php endif; ?>	
					</tbody>
				</table>			

			</div>
			</div>	
		</div>
	</div>
</div>



		

