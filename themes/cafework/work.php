	
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
								<h3>Projetos</h3>
								<div class="box-tools">
								</div>
							</header>	
						<div class="box-body">
					
							<a href="<?= url("/works/works-add"); ?>" class="btn btn-primary"><i class='fa fa-i fa-plus-circle'></i>Projeto</a>

						</div>
						<div class="box-body">
							<table class="table table-bordered table-hover">
								<thead>
									<th scope="col" style="text-align:center;font-size:12px;">NOME DO PROJETO</th>
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
											<?php 	var_dump($work);?>
											<tr scope="row">	
												<td scope="col" style="text-align:center;font-size:12px;"><?php echo $work->name;?></td>
												<td scope="col" style="text-align:center;font-size:12px;"><?php echo $customer->name; ?></td>
												<td scope="col" style="text-align:center;font-size:12px;"><?php echo $customer->email; ?></td>
												<td scope="col" style="text-align:center;font-size:12px;"><?= ($work->date_initial ? date_fmt($works->date_initial, "d/m/Y") : null); ?></td>
												<td scope="col" style="text-align:center;font-size:12px;"><?= ($work->date_final ? date_fmt($works->date_final, "d/m/Y") : null); ?></td>
												<td scope="col" style="text-align:center;font-size:12px;">
													<?php if($work->status == "active"){
															echo "ATIVO";
														}else if($work->status == "finished"){
															echo "FINALIZADO";
														}else if($work->status == "budgeting"){
															echo "ORÇANDO";
														}
													?>					
												</td>
												<td scope="col" style="text-align:center;font-size:12px;">
													<a title="Gerenciar Projetos e Serviços" href="<?= url("/works/project/{$work->id}");?>" class="btn btn-primary btn-xs"><span class="fa fa-file-o fw-fa"></span></a>
													<a title="Editar" href="<?= url("/works/works-edit/{$work->id}"); ?>" class="btn btn-warning btn-xs"><span class="fa fa-edit fw-fa"></span></a>
													<a title="Deletar" class="btn-simple btn btn-danger btn-xs"  href="#"
														data-post="<?= url("/works/works-delete/{$work->id}"); ?>"
														data-action="delete"
														data-confirm="Tem Certeza que Deseja Deletar esse Projeto?"
														data-id="<?= $work->id; ?>"><span class="fa fw-i fa-remove"></span></a>
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
	<footer class="main-footer bg-white p-a-5"> 
		<div class="container-fluid p-t-15">
			<div class="row">
				<div class="col-xs-12">
					
				</div>
			</div>
			<!-- END: .row -->		
		</div>	
    </footer>


    <!-- END: .main-footer -->
</div>
<!-- END: .app-main -->	
	



		



		

