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
						<h3>Nova Consulta</h3>
						<div class="box-tools">
						</div>
					</header>
				</div>
				
				<a href="<?= url("/clinic/appointment-add"); ?>" class="btn btn-primary"><i class='fa fa-fw fa-plus-circle'></i>Novo Consulta</a>
				<br><br>
				
			<div class="card-content table-responsive">
			

				<table class="table table-bordered table-hover">
					<thead>
						<th scope="col" style="text-align:center;font-size:12px;">Código</th>
						<th scope="col"style="text-align:center;font-size:12px;">Nome do Cliente</th>
						<th scope="col" style="text-align:center;font-size:12px;">Data Do Atendimento</th>
						<th scope="col" style="text-align:center;font-size:12px;">Horário do Atendimento</th>
						<th scope="col" style="text-align:center;font-size:12px;">Status</th>
						<th scope="col" style="text-align:center;font-size:12px;">Ações</th>	
					</thead>
					<tbody>	
					<?php if (!empty($appointment)): ?>
						<?php foreach ($appointment as $appointment):?>
					   
						<tr scope="row">
							<td scope="col" style="text-align:center;font-size:12px;"><?php echo $appointment->code;?></td>
							<td scope="col" style="text-align:center;font-size:12px;"><?php echo $appointment->name;?></td>
							<td scope="col" style="text-align:center;font-size:12px;"><?php echo $appointment->date_initial; ?></td>
							<td scope="col" style="text-align:center;font-size:12px;"><?php if($appointment->status == "active"){
								echo "Em Atendimento";
							}else if($appointment->status == "finished"){
								echo "Atendimento Finalizado";
							}
							?></td>
							<td scope="col" style="text-align:center;font-size:12px;">
							<a title="Visualizar Consulta" href="<?= url("/clinic/project/{$service->id}");?>" class="btn btn-primary btn-xs"><span class="fa fa-file-o fw-fa"></span></a>
							<a title="Editar" href="<?= url("/clinic/appointment-edit/{$appointment->id}"); ?>" class="btn btn-warning btn-xs"><span class="fa fa-edit fw-fa"></span></a>
							<a title="Deletar" class="btn-simple btn btn-danger btn-xs" title="" href="#"
                                   data-post="<?= url("/clinic/appointment"); ?>"
                                   data-action="delete"
                                   data-confirm="Tem Certeza que Deseja Deletar esse Serviço?"
                                   data-id="<?= $appointment->id; ?>"><span class="fa fa-remove fw-fa"></span></a>
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

