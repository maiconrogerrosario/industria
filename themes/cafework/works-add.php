<?php $v->layout("_theme"); ?>

 <!-- begin .app-main -->
<div class="app-main">
    <!-- begin .main-heading -->
    <header class="main-heading shadow-2dp">
            <!-- begin dashhead -->
			   <!--	<div class="dashhead bg-white">
					<div class="dashhead-titles">

						<h3 class="dashhead-title">Serviços</h3>
						<h6 class="dashhead-subtitle p-t-15">
							<a href="index.html">chaldene</a>
							/ forms
							T
						</h6>
					</div>

					<div class="dashhead-toolbar ">
						<div class="dashhead-toolbar-item p-t-30">
							<a href="index.html">chaldene</a>
							/ forms
							/ Form Wizard
						</div>
					</div>
				</div>-->
            <!-- END: dashhead -->
    </header>
          <!-- END: .main-heading -->

          <!-- begin .main-content -->
    <div class="main-content bg-clouds">
        <!-- begin .container-fluid -->
        <div class="container-fluid p-t-15">
			<div class="row">
				<div class="col-xs-12">
					<div class="box">
						<header>
							<h4>Cadastro de Projetos ou Serviço<small></small> </h4>
							<!-- begin box-tools -->
							<!--<div class="box-tools">
							<a class="fa fa-fw fa-minus" href="#" data-box="collapse"></a>
							<a class="fa fa-fw fa-times" href="#" data-box="close"></a>
							</div>-->
							<!-- END: box-tools -->
						</header>
						<div class="box-body">
							<form class="form-horizontal" action="<?= url("/work/work-add"); ?>" method="post">
								<input type="hidden" name="action" value="create"/>
								<div>
									<section>
										<div class="form-group">
											<div class="col-md-12">
												<label for="customer_id" >Cliente:</label>
												<select class="form-control js-example-theme-single"  name="customer_id" id="customer_id" >
													<?php foreach($customers as $customer): ?>
														<option value="<?=$customer->id; ?>"><?=  $customer->name;?></option>
													<?php endforeach; ?>
												</select>	
											</div>	
										</div>		
										<div class="form-group">
											<div class="col-md-12">
												<label for="name">Nome do Projeto ou Serviço:</label>
												<input type="text" class="form-control" id="name" name="name" placeholder="Nome da Obra ou Serviço:"/>
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-10">
												<label for="address_street">Lograouro:</label>
												<input type="text" class="form-control"  id="address_street" name="address_street" placeholder="Lograouro:"/>
											</div>
								
											<div class=" col-md-2">
												<label for="address_number">Número:</label>
												<input type="text" class="form-control" id="address_number" name="address_number" placeholder="Número:" />
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-6">
												<label for="address_neighborhood">Bairro:</label>
												<input type="text" class="form-control" id="address_neighborhood" name="address_neighborhood" placeholder="Bairro:"/>
											</div>
											<div class=" col-md-6">
												<label for="address_complement">Complemento:</label>
												<input  type="text" class="form-control" id="address_complement" name="address_complement" placeholder="Complemento:"/>
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-6">
												<label for="address_postalcode">CEP:</label>
												<input type="text" class="form-control mask-cep" id="address_postalcode" name="address_postalcode" placeholder="00000-000"/>
											</div>
											<div class="col-md-6">
												<label for="address_city">Cidade:</label>
												<input type="text" class="form-control" id="address_city" placeholder="Cidade:" name="address_city"/>
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-6">
												<label for="address_state">Estado:</label>
												<input type="text" class="form-control" id="address_state" name="address_state" placeholder="Estado:"/>
											</div>
											<div class=" col-md-6">
												<label for="address_country">Páis:</label>
												<input type="text" class="form-control" id="address_country" name="address_country" placeholder="País:"/>
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-4">
												<label for="date_initial">Data de Início:</label>
												<input type="date" id="date_initial" name="date_initial"  class="form-control" id="date_initial" placeholder="Data Inicial:" required>
											</div>
											<div class="col-md-4">
												<label for="date_final">Data de Entrega:</label>
												<input type="date" id="date_final" name="date_final"  class="form-control"  placeholder="Data Final:" required>
											</div>
											<div class="col-md-4">
												<label for="value">Preço do Projeto:</label>
												<input class="form-control mask-money" type="text" id="projectcost" name="projectcost" required/>
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-12">
												<label for="observation">Observações:</label>
												<textarea type="text" class="form-control" id="observation" name="observation" placeholder="Observações:"></textarea>
											</div>	
										</div>
										<div class="form-group">
											<div class="col-md-12">
												<label for="status">Estado da Obra:</label>
												<select name="status" id="status" class="form-control" required>
													<option value="active">Ativa</option>
													<option value="finished">Finalizada</option>
													<option value="budgeting">Orçando</option>		
												</select>
											</div>	
										</div>
										<div class="form-group">
											<div class="col-lg-12">
												<button class="btn btn-primary">Cadastrar</button>
											</div>
										</div>				
									</section>
								</div>
							</form>
						</div>
					</div>
				</div>
            </div>
        </div>
        <!-- END: .container-fluid -->
    </div>
          <!-- END: .main-content -->

          <!-- begin .main-footer -->
           <!--<footer class="main-footer bg-white p-a-5">
		  
				<div class="col-md-6">
					<label for="date_final">Data de Entrega da Obra</label>
					<input id="autocomplete" title="type &quot;a&quot;">
				</div>	
		
          </footer>-->
          <!-- END: .main-footer -->

</div>
        <!-- END: .app-main -->	



<?php $v->start("scripts"); ?>
<script>
   $(document).ready(function() {
    $('.js-example-theme-single').select2();
});




</script>


 




<?php $v->end(); ?>
