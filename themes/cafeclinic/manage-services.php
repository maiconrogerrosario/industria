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
						<h3>Gerenciamento de Serviços</h3>
						<div class="box-tools">
						</div>
					</header>
				</div>
				
				<a href="<?= url("/clinic/add-services"); ?>" class="btn btn-primary"><i class='fa fa-fw fa-plus-circle'></i>Novo Serviço</a>
				<br><br>
				
			<div class="card-content table-responsive">
			

				<table class="table table-bordered table-hover">
					<thead>
						<th scope="col" style="text-align:center;font-size:12px;">NOME DO SERVIÇO</th>
						<th scope="col"style="text-align:center;font-size:12px;">PREÇO DO SERVIÇO</th>
						<th scope="col" style="text-align:center;font-size:12px;">DATA DA CRIAÇÃO</th>
						<th scope="col" style="text-align:center;font-size:12px;">STATUS</th>
						<th scope="col" style="text-align:center;font-size:12px;">AÇÕES</th>	
					</thead>
					<tbody>	
					<?php if (!empty($services)): ?>
						<?php foreach ($services as $service):?>
					   
						<tr scope="row">
							<td scope="col" style="text-align:center;font-size:12px;"><?php echo $service->name;?></td>
							<td scope="col" style="text-align:center;font-size:12px;"><?php echo $service->price; ?></td>
							<td scope="col" style="text-align:center;font-size:12px;"><?php echo $service->date; ?></td>
							<td scope="col" style="text-align:center;font-size:12px;"><?php if($service->status == "active"){
								echo "Serviço Ativo";
							}else if($work->status == "finished"){
								echo "Serviço Finalizado";
							}
							?></td>
							<td scope="col" style="text-align:center;font-size:12px;">
							<a title="Visualizar Serviços" href="<?= url("/clinic/project/{$service->id}");?>" class="btn btn-primary btn-xs"><span class="fa fa-file-o fw-fa"></span></a>
							<a title="Editar" href="<?= url("/clinic/service-edit/{$service->id}"); ?>" class="btn btn-warning btn-xs"><span class="fa fa-edit fw-fa"></span></a>
							<a title="Deletar" class="btn-simple btn btn-danger btn-xs" title="" href="#"
                                   data-post="<?= url("/clinic/work"); ?>"
                                   data-action="delete"
                                   data-confirm="Tem Certeza que Deseja Deletar esse Serviço?"
                                   data-id="<?= $clinic->id; ?>"><span class="fa fa-remove fw-fa"></span></a>
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



		


		

