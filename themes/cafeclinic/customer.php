<?php $v->layout("_theme"); ?>

<div class="app-main">
    <!-- begin .main-heading -->
    <header class="main-heading shadow-2dp">
		<!-- begin dashhead -->
		<div class="dashhead bg-white">
			<div class="dashhead-titles">
					<!--<h6 class="dashhead-subtitle">
					Clientes
				</h6>-->
				<h3 class="dashhead-title">Clientes</h3>
			</div>
			<div class="dashhead-toolbar">
				<div class="dashhead-toolbar-item">
				<!--	<a href="index.html">chaldene</a>
					/ tables
					/ Table Basic-->
				</div>
			</div>
		</div>
		<!-- END: dashhead -->
    </header>
    <!-- END: .main-heading -->
    <!-- begin .main-content -->
    <div class="main-content bg-clouds">
		<!-- begin .container-fluid -->
        <div class="container-fluid p-t-15">
            <!-- BEGIN: .row -->
            <div class="row">
                <div class="col-md-12">
					<div class="box shadow-2dp">
						<header>
							<a href="<?= url("/clinic/customer-add"); ?>" class="btn btn-primary"><i class='fa fa-fw fa-plus-circle'></i>Novo Cliente</a>

							<!-- begin box-tools -->
							<!-- <div class="box-tools">
							<a class="fa fa-fw fa-minus" href="#" data-box="collapse"></a>
							<a class="fa fa-fw fa-times" href="#" data-box="close"></a>
							</div>-->
							<!-- END: box-tools -->
						
							
							
						</header>
						<div class="box-body" style="">
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
													<a href="<?= url("/clinic/customer-edit/{$customer->id}"); ?>" class="btn btn-warning btn-xs">Editar</a>
													<a class="btn-simple btn btn-danger btn-xs" title="" href="#"
														data-post="<?= url("/clinic/customer"); ?>"
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
		
		    <input type="text" id="esporte" placeholder="Informe um esporte"/>

		
	</div>
    <!-- begin .main-footer -->
    <footer class="main-footer bg-white p-a-5">

    </footer>
    <!-- END: .main-footer -->
 </div>
		      

 

<?php $v->start("scripts"); ?>
  <script>
$(function() {
  var esportes = [
    "Natação",
    "Futebol",
    "Vôlei",
    "Basquete"
  ];
  $("#esporte").autocomplete({
    source: esportes
  });
});
</script>
	
	
	
<?php $v->end(); ?>

		


		



 



		


		

