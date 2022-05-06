<?php $v->layout("_theme"); ?>
	
<div class="app-main">
	<!-- begin .main-heading -->
   <!--  <header class="main-heading shadow-2dp">
		<!-- begin dashhead -->
       <!-- <div class="dashhead bg-white">
            <div class="dashhead-titles">
				<h6 class="dashhead-subtitle">
                  chaldene
                </h6>
                <h3 class="dashhead-title">Dashboard</h3>
            </div>
            <div class="dashhead-toolbar">
				<div class="dashhead-toolbar-item">
					<a href="index.html">chaldene</a>
                  / Dashboard
                </div>
            </div>
        </div>
		<!-- END: dashhead -->
    <!--  </header>-->
    <!-- END: .main-heading -->
	
    <!-- begin .main-content -->
	<div class="main-content bg-clouds">
	    <!-- begin .container-fluid -->
        <div class="container-fluid p-t-15">
			<div class="row">
				<div class="col-xs-12">
					<div class="box">
							<header>
								<h3>Fornecedores</h3>
								<div class="box-tools">
								</div>
							</header>	
						<div class="box-body">
					
							<a href="<?= url("/work/supplier-add"); ?>" class="btn btn-primary"><i class='fa fa-i fa-plus-circle'></i>Fornecedor</a>

						</div>
						<div class="box-body">
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
											<?php 	$service  = $supplier->getService();?>
											<tr>
												<td scope="col" style="text-align:center;font-size:12px;"><?php echo $supplier->name;?></td>
												<td scope="col" style="text-align:center;font-size:12px;"><?php echo $supplier->email;?></td>
												<td scope="col" style="text-align:center;font-size:12px;"><?php echo $supplier->phone1;?></td>
												<td scope="col" style="text-align:center;font-size:12px;"><?php echo $supplier->mobile;?></td>
												<td scope="col" style="text-align:center;font-size:12px;"><?php echo $service->name;?></td>
												<td scope="col" style="text-align:center;font-size:12px;">
													<a href="<?= url("/work/supplier-edit/{$supplier->id}"); ?>" class="btn-simple btn btn-warning btn-xs"><span class="fa fa-edit fw-fa"></span></a>
													<a class="btn-simple btn btn-danger btn-xs" title="" href="#"
														data-post="<?= url("/work/supplier-delete/{$supplier->id}"); ?>"
														data-action="delete"
														data-confirm="Tem Certeza que Deseja Deletar esse Fornecedor?"
														data-id="<?= $supplier->id; ?>"><span class="fa fa-remove fw-fa"></span></a> 
												</td>
											</tr>
										<?php endforeach; ?>
									<?php endif; ?>	
								</tbody>
							</table>			
						</div>
						<div class="box-body">
							<?=$paginator?>	 
						</div>	
					</div>	
				</div>
			</div>
			<!-- END: .row -->		
		</div>		
	</div>	
    <!-- END: .main-content -->
	
    <!-- begin .main-footer -->

    <!-- END: .main-footer -->
</div>
<!-- END: .app-main -->			


		


		


		

