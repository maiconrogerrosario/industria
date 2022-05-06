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
						<h3>Obras</h3>
						<div class="box-tools">
						</div>
					</header>
				</div>
				
				<a href="<?= url("/work/work-add"); ?>" class="btn btn-primary"><i class='fa fa-fw fa-plus-circle'></i>Novo Obra ou Serviço</a>
				<br><br>
				
			<div class="card-content table-responsive">
			

				<table class="table table-bordered table-hover">
					<thead>
						<th scope="col" style="text-align:center;font-size:12px;">NOME DA OBRA</th>
						<th scope="col"style="text-align:center;font-size:12px;">PROPRIETÁRIO</th>
						<th scope="col" style="text-align:center;font-size:12px;">EMAIL</th>
						<th scope="col" style="text-align:center;font-size:12px;">INÍCIO DA OBRA</th>
						<th scope="col" style="text-align:center;font-size:12px;">ENTREGA DA OBRA</th>
						<th scope="col" style="text-align:center;font-size:12px;">STATUS</th>
						<th scope="col" style="text-align:center;font-size:12px;">AÇÕES</th>	
					</thead>
					<tbody>	
					<?php if (!empty($works)): ?>
						<?php foreach ($works as $work):?>
					    <?php 	$customer  = $work->getCustomer();?>
						<tr scope="row">
							<td scope="col" style="text-align:center;font-size:12px;"><?php echo $work->name;?></td>
							<td scope="col" style="text-align:center;font-size:12px;"><?php echo $customer->name; ?></td>
							<td scope="col" style="text-align:center;font-size:12px;"><?php echo $customer->email; ?></td>
							<td scope="col" style="text-align:center;font-size:12px;"><?php echo $work->date_initial; ?></td>
							<td scope="col" style="text-align:center;font-size:12px;"><?php echo $work->date_final; ?></td>
							<td scope="col" style="text-align:center;font-size:12px;"><?php if($work->status == "active"){
								echo "Ativo";
							}else if($work->status == "finished"){
								echo "Finalizado";
							}else if($work->status == "budgeting"){
								echo "Orçando";
							}
							?></td>
							<td scope="col" style="text-align:center;font-size:12px;">
							<a title="Gerenciar Projetos e Serviços" href="<?= url("/work/project/{$work->id}");?>" class="btn btn-primary btn-xs"><span class="fa fa-file-o fw-fa"></span></a>
							<a title="Editar" href="<?= url("/app/work-edit/{$work->id}"); ?>" class="btn btn-warning btn-xs"><span class="fa fa-edit fw-fa"></span></a>
							<a title="Deletar" class="btn-simple btn btn-danger btn-xs" title="" href="#"
                                   data-post="<?= url("/app/work"); ?>"
                                   data-action="delete"
                                   data-confirm="Tem Certeza que Deseja Deletar esse Fornecedor?"
                                   data-id="<?= $work->id; ?>"><span class="fa fa-remove fw-fa"></span></a>
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



		


		

