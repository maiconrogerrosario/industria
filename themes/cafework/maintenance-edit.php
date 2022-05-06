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
							<h4>Cadastro de Manutenção de Equipamento<small></small> </h4>
							<!-- begin box-tools -->
							<!--<div class="box-tools">
							<a class="fa fa-fw fa-minus" href="#" data-box="collapse"></a>
							<a class="fa fa-fw fa-times" href="#" data-box="close"></a>
							</div>-->
							<!-- END: box-tools -->
						</header>
						<div class="box-body">
							<form  class="form-horizontal" id="external" style="display:none;" action="<?= url("/app/maintenance-edit{$maintenance->id}"); ?>" method="post">
								<input type="hidden" name="action" value="update"/>	
								<input type="hidden" name="type_collaborator" value="internal_collaborator"/>
								<div>
									<section>
										<div class="form-group">
											<div class="col-md-12">
												<label for="maintenance_type">Tipo de Manutenção</label>
												<select name="maintenance_type" id="maintenance_type"  class="form-control">			
													<option value="Manutenção Preventiva"<?php if($maintenance->maintenance_type=="Manutenção Preventiva"){echo "selected";}?>>MANUTENÇÃO PREVENTIVA</option>
													<option value="Manutenção Correntiva"<?php if($maintenance->maintenance_type=="Manutenção Correntiva"){echo "selected";}?>>MANUTENÇÃO CORRENTIVA</option>
													<option value="Manutenção Preditiva"<?php if($maintenance->maintenance_type=="Manutenção Preditiva"){echo "selected";}?>>MANUTENÇÃO PREDITIVA</option>
												</select>
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-12">
												<label for="equipment_id">Equipamento</label>
												<select name="equipment_id" id="equipment_id" class="form-control">
													<?php foreach($equipments as $equipment):?>
														<option value="<?php echo $equipment->id;?>"<?php if($maintenance->equipment_id == $equipment->id){echo "selected";}?>><?php echo $equipment->name;?></option>      
													<?php endforeach;?>			
												</select>
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-12">
												<label for="service_id">Tipo de Serviço:</label>
												<select name="service_id" id="service_id"  class="form-control">
													<?php foreach($services as $service):?>
														<option value="<?php echo $service->id;?>"><?php echo $service->name;?></option>      
													<?php endforeach;?>			
												</select>
											</div>
										</div>
					
										<div class="form-group">
											<div class="col-md-6">
												<label for="date_initial">Data da Manutenção Inicial</label>
												<input type="date" value="<?php echo $maintenance->date_initial;?>" id="date_initial" name="date_initial"  class="form-control" placeholder="Data Inicial" >
											</div>
				
											<div class="col-md-6">
												<label for="time_initial">Horário  da Manutenção Inicial</label>
												<input type="time" value="<?php echo $maintenance->time_initial;?>" id="time_initial" name="time_initial"  class="form-control" placeholder="Horário Final" >
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-6">
												<label for="date_final">Data da Manutenção Final</label>
												<input type="date" value="<?php echo $maintenance->date_final;?>" id="date_final" name="date_final"  class="form-control"  placeholder="Data Final">
											</div>
											<div class="col-md-6">
												<label for="time_final">Horário da Manutenção Final</label>
												<input type="time" value="<?php echo $maintenance->time_final;?>" id="time_final" name="time_final"  class="form-control"  placeholder="Hora Final">
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-12">
												<label for="annotations">Anotações</label>
												<textarea type="text"  class="form-control" id="annotations" name="annotations" placeholder="<?php echo $maintenance->annotations;?>"></textarea>
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-12">
												<label for="collaborator_name">Manutenção Realizada Por:</label>		
												<select name="collaborator_name"  class="form-control" required>
													<?php foreach($suppliers as $supplier):?>
														<option value="<?= $supplier->id;?>" <?php if($maintenance->collaborator_name == $supplier->name){echo "selected";}?>><?= $supplier->name;?></option>      
													<?php endforeach;?>
												</select>
											</div>	
										</div>		
										<div class="form-group">
											<div class="col-md-12">
												<label for="status_id">Estado do Serviço</label>
												<select name="status_id" id="status_id" class="form-control" required>
													<?php foreach($statuses as $statuse):?>
														<option value="<?php echo $statuse->id; ?>"><?php echo $statuse->name;?></option>
													<?php endforeach; ?>
												</select>
											</div>		
										</div>		
										<div class="form-group">
											<div class="col-lg-12">
												<label for="price">Custo Total da Manutenção</label>
												<div class="input-group">
													<span class="input-group-addon"><i class="fa fa-usd"></i></span>
													<input value="<?php echo $maintenance->price;?>" type="text" id="price" class="form-control" name="price" placeholder="Custo Total da Manutenção">
												</div>
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
		  
				<div class="col-lg-6">
					<label for="date_final">Data de Entrega da Obra</label>
					<input id="autocomplete" title="type &quot;a&quot;">
				</div>	
		
          </footer>-->
          <!-- END: .main-footer -->

</div>
        <!-- END: .app-main -->	

<?php $v->start("scripts"); ?>

<script>
  function typeCollaborator(){
    if (document.getElementById('collaborator').value == 'internal'){
      document.getElementById('internal').style.display='block';
      document.getElementById('external').style.display='none';
    }else{
      document.getElementById('external').style.display='block';
      document.getElementById('internal').style.display='none';
    }
	
  }

</script>




<?php $v->end(); ?>







