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
						<h3>Clientes</h3>
						<div class="box-tools">

						</div>
						

					</header>
					
				</div>	
	
				<a href="<?= url("/work/customer-add"); ?>" class="btn btn-primary"><i class='fa fa-fw fa-plus-circle'></i>Novo Cliente</a>
				<br></br>
				
			<div class="card-content table-responsive">

				<table class="table table-bordered table-hover">
					<thead>
						<th scope="col" style="text-align:center;font-size:12px;">Nome do Cliente</th>
						<th scope="col" style="text-align:center;font-size:12px;">CPF/CNPJ</th>
						<th scope="col" style="text-align:center;font-size:12px;">Email</th>
						<th scope="col" style="text-align:center;font-size:12px;">Telefone</th>
						<th scope="col" style="text-align:center;font-size:12px;">Ações</th>
					</thead>
					<tbody>	
					<?php if (!empty($customers)): ?>
						<?php foreach ($customers as $customer):?>
						<tr scope="row">
							<td scope="col" style="text-align:center;font-size:12px;"><?php echo $customer->name;?></td>
							<td scope="col" style="text-align:center;font-size:12px;"><?php echo $customer->contact; ?></td>
							<td scope="col" style="text-align:center;font-size:12px;"><?php echo $customer->email; ?></td>
							<td scope="col" style="text-align:center;font-size:12px;"><?php echo $customer->phone1; ?></td>
							<td scope="col" style="text-align:center;font-size:12px;">
							<a href="<?= url("/work/customer-edit/{$customer->id}"); ?>" class="btn btn-warning btn-xs">Editar</a>
							<a class="btn-simple btn btn-danger btn-xs" title="" href="#"
                                   data-post="<?= url("/work/customer"); ?>"
                                   data-action="delete"
                                   data-confirm="Tem Certeza que Deseja Deletar esse Fornecedor?"
                                   data-id="<?= $customer->id; ?>">Deletar</a>  
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



		


		

