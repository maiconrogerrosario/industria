<?php $v->layout("_theme"); ?>

 <!-- begin .app-main -->
<div class="app-main">
    <!-- begin .main-heading -->
    <header class="main-heading shadow-2dp">
        <!-- begin dashhead -->
		<!--<div class="dashhead bg-white">
			<div class="dashhead-titles">
				<h3 class="dashhead-title">Serviços</h3>
				<h6 class="dashhead-subtitle p-t-15">
				<a href="index.html">chaldene</a>
					/ forms
					/ Form Wizard
				</h6>
			</div>
			<div class="dashhead-toolbar ">
				<div class="dashhead-toolbar-item p-t-30">
					<a href="index.html">chaldene</a>
						/ forms
						/ Form Wizard
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
				<div class="row">
					<div class="col-xs-12">
						<div class="box">
							<header>
								<h4>Editar Fornecedor<small></small></h4>
								<!-- begin box-tools -->
								<!--<div class="box-tools">
								<a class="fa fa-fw fa-minus" href="#" data-box="collapse"></a>
								<a class="fa fa-fw fa-times" href="#" data-box="close"></a>
								</div>-->
								<!-- END: box-tools -->
							</header>
							<div class="box-body">
								<form class="form-horizontal" action="<?= url("/work/supplier-edit/{$supplier->id}"); ?>" method="post">
									<input type="hidden" name="action" value="update"/>	
										<div>
											<section>
											
												<div class="form-row">
													<div class="form-group">
														<div class="col-md-12">
															<label for="name">Nome do Fornedor:</label>
															<input type="text" class="form-control" id="name" name="name" value="<?php echo $supplier->name;?>" placeholder="Nome do Fornedor:"/>
														</div>
													</div>
												</div>
												
												<div class="form-group">
													<div class="col-md-12">
														<label for="supplier_type">Tipo de Serviço:</label>
														<select name="supplier_type" id="supplier_type"   class="form-control">
															<?php foreach($suppliertype as $suppliertype): ?>
																<option value="<?php echo $supplier->id; ?>"<?php if($suppliertype->id == $supplier->id){echo "selected";}?>><?php echo $suppliertype->name;?></option>  
															<?php endforeach; ?> 
														</select>
													</div>	
												</div>
												<div class="form-row">
													<div class="form-group">
														<div class="col-md-6">
															<label for="email">Email:</label>
															<input type="email" class="form-control" id="email" placeholder="Email:" name="email" value="<?php echo $supplier->email;?>" />
														</div>
														<div class=" col-md-6">
															<label for="document">CPF/CNPJ:</label>
															<input type="text" class="form-control mask-doc2" id="document" placeholder="00.000.000/0000-00" name="document" value="<?php echo $supplier->document;?>" />
														</div>
													</div>
												</div>
												<div class="form-row">
													<div class="form-group">
														<div class="col-md-12">
															<label for="contact">Contato:</label>
															<input id="contact"  type="text" class="form-control" name="contact" placeholder="Contato:" value="<?php echo $supplier->contact;?>" />
														</div>	
													</div>					
												</div>
												<div class="form-row">
													<div class="form-group">
														<div class="col-md-12">
															<label for="site">Site:</label>
															<input type="text" class="form-control" id="site" name="site" placeholder="Site:"value="<?php echo $supplier->site;?>" />
														</div>
													</div>
												</div>
												<div class="form-row">
													<div class="form-group">
														<div class="col-md-6">
															<label for="phone1">Telefone:</label>
															<input id="phone1"  type="text" class="form-control mask-phone" name="phone1" placeholder="(00)0000-0000" value="<?php echo $supplier->phone1;?>" />
														</div>
														<div class=" col-md-6">
															<label for="mobile">Telefone Celular:</label>
															<input id="mobile"  type="text" class="form-control mask-mobile" name="mobile" placeholder="(00)00000-0000" value="<?php echo $supplier->mobile;?>" />
														</div>
													</div>
												</div>
												<div class="form-row">
													<div class="form-group">	
														<div class="col-md-6">
															<label for="phone2">Telefone para Contato:</label>
															<input id="phone2"  type="text" class="form-control mask-phone" name="phone2" placeholder="(00)0000-0000" value="<?php echo $supplier->phone2;?>"/> 
														</div>
														<div class="col-md-6">
															<label for="fax">Fax:</label>
															<input id="fax" type="text" class="form-control mask-phone" name="fax" placeholder="(00)0000-0000" value="<?php echo $supplier->fax;?>"/>
														</div>
													</div>
												</div>
												<div class="form-row">
													<div class="form-group">
														<div class="col-md-10">
															<label for="address_street">Lograouro:</label>
															<input type="text" class="form-control"  id="address_street" name="address_street" placeholder="Lograouro:" value="<?php echo $supplier->address_street;?>"/>
														</div>
														<div class=" col-md-2">
															<label for="address_number">Número:</label>
															<input type="text" class="form-control" id="address_number" name="address_number" placeholder="Número:" value="<?php echo $supplier->address_number;?>"/>
														</div>
													</div>
												</div>
												<div class="form-row">
													<div class="form-group">
														<div class="col-md-6">
															<label for="address_neighborhood">Bairro:</label>
															<input type="text" class="form-control" id="address_neighborhood" name="address_neighborhood" placeholder="Bairro:" value="<?php echo $supplier->address_neighborhood;?>"/>
														</div>
														<div class=" col-md-6">
															<label for="address_complement">Complemento:</label>
															<input  type="text" class="form-control" id="address_complement" name="address_complement" placeholder="Complemento:" value="<?php echo $supplier->address_complement;?>"/>
														</div>
													</div>
												</div>	
												<div class="form-row">
													<div class="form-group">
														<div class="col-md-6">
															<label for="address_postalcode">CEP:</label>
															<input type="text" class="form-control mask-cep" id="address_postalcode" name="address_postalcode" placeholder="00000-000" value="<?php echo $supplier->address_postalcode;?>"/>
														</div>
														<div class="col-md-6">
															<label for="address_city">Cidade:</label>
															<input type="text" class="form-control" id="address_city" placeholder="Cidade:" name="address_city" value="<?php echo $supplier->address_city;?>"/>
														</div>
													</div>
												</div>
												<div class="form-row">
													<div class="form-group">
														<div class="col-md-6">
															<label for="address_state">Estado:</label>
															<input type="text" class="form-control" id="address_state" name="address_state" placeholder="Estado:" value="<?php echo $supplier->address_state;?>"/>
														</div>
														<div class=" col-md-6">
															<label for="address_country">Páis:</label>
															<input type="text" class="form-control" id="address_country" name="address_country" placeholder="País:" value="<?php echo $supplier->address_country;?>"/>
														</div>
													</div>
												</div>
												<div class="form-row">
													<div class="form-group">
														<div class="col-md-12">
															<label for="observation">Observação:</label>			
															<textarea name="observation" class="form-control" id="observation" placeholder="Observação:"><?php echo $supplier->observation;?></textarea>
														</div>
													</div>
												</div>
												<div class="form-row">
													<div class="form-group">
														<div class="col-md-4">
															<button type="submit" class="btn btn-primary">Alterar</button>
														</div>		
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
        <footer class="main-footer bg-white p-a-5">
          
        </footer>
         <!-- END: .main-footer -->
</div>
    <!-- END: .app-main -->	





