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
				
				<a href="<?= url("/work/supplier-add"); ?>" class="btn btn-primary"><i class='fa fa-fw fa-plus-circle'></i>Novo Fornecedor</a>
				<br><br>
				
			<div class="card-content table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
						<th scope="col" style="text-align:center;font-size:12px;">NOME</th>
						<th scope="col" style="text-align:center;font-size:12px;">EMAIL</th>
						<th scope="col" style="text-align:center;font-size:12px;">TELEFONE</th>
						<th scope="col" style="text-align:center;font-size:12px;">CELULAR</th>
						<th scope="col" style="text-align:center;font-size:12px;">TIPO</th>
						<th scope="col" style="text-align:center;font-size:12px;">AÇÕES</th>
					</thead>
					<tbody>
					<?php if (!empty($suppliers)): ?>
						<?php foreach ($suppliers as $supplier):?>
					    <?php 	$supplierType  = $supplier->getSupplierType();?>
						<tr>
							<td scope="col" style="text-align:center;font-size:12px;"><?php echo $supplier->name;?></td>
							<td scope="col" style="text-align:center;font-size:12px;"><?php echo $supplier->email;?></td>
							<td scope="col" style="text-align:center;font-size:12px;"><?php echo $supplier->phone;?></td>
							<td scope="col" style="text-align:center;font-size:12px;"><?php echo $supplier->mobile;?></td>
							<td scope="col" style="text-align:center;font-size:12px;"><?php echo $supplierType;?></td>
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
				</table>			
			</div>
			</div>	
		</div>
	</div>
</div>



		


		


		


		

