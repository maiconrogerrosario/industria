<?php $v->layout("_theme"); ?>

 <div class="main-content bg-clouds">
    <!-- begin .container-fluid -->
    <div class="container-fluid p-t-15">
        <div class="box">
            <header class="bg-primary">
				<h4>Nova Manutenção</h4>
            </header>	
		</div>
		
		<div class="form-horizontal">
			<div class="form-row">
				<div class="form-group">
					<div class="col-md-12">
						<label for="collaborator"> Tipo de Colaborador</label>
						<select name="collaborator" id="collaborator"  class="form-control" onchange="typeCollaborator();"  >
							<option value="internal">Colaborador Interno</option>
							<option value="external" >Colaborador Externo </option>		
						</select>
					</div>					
				</div>
			</div>
		</div>	
		<form id="internal" style="display:block;"   class="form-horizontal" action="<?= url("/app/maintenance-add"); ?>" method="post">
			<input type="hidden" name="action" value="create"/>	
			<input type="hidden" name="type_collaborator" value="internal_collaborator"/>
			
			<div class="form-row">
				<div class="form-group">
					<div class="col-md-12">
						<label for="maintenance_type">Tipo de Manutenção</label>
						<select name="maintenance_type" id="maintenance_type"  class="form-control" required>
							<option value="">SELECIONE TIPO DE MANUTENÇÃO</option>
							<option value="Manutenção Preventiva">MANUTENÇÃO PREVENTIVA</option>
							<option value="Manutenção Correntiva">MANUTENÇÃO CORRENTIVA</option>
							<option value="Manutenção Preditiva">MANUTENÇÃO PREDITIVA</option>
						</select>
					</div>
				</div>
			</div>
				
			<div class="form-row">
				<div class="form-group">
					<div class="col-md-12">
						<label for="equipment_id">Equipamento</label>
						<select name="equipment_id" id="equipment_id" class="form-control" required>
							<option value="">SELECIONE</option>
							<?php foreach($equipments as $equipment):?>
							<option value="<?php echo $equipment->id; ?>"><?php echo $equipment->id." - ".$equipment->name?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
			</div>
				
			<div class="form-row">
				<div class="form-group">
					<div class="col-md-12">
						<label for="service_id">Tipo de Serviço:</label>
						<select name="service_id" id="service_id"  class="form-control" required>
							<option value="">SELECIONE TIPO DE SERVIÇO</option>
							<?php foreach($services as $service):?>
							<option value="<?php echo $service->id;?>"><?php echo $service->name?></option>
							<?php endforeach; ?>			
						</select>
					</div>
				</div>
			</div>
					
			<div class="form-row">
				<div class="form-group">
					<div class="col-md-6">
						<label for="date_initial">Data da Manutenção Inicial</label>
						<input type="date" id="date_initial" name="date_initial"  class="form-control" id="date_initial" placeholder="Data Inicial" required>
					</div>
				
					<div class="col-md-6">
						<label for="time_initial">Horário  da Manutenção Inicial</label>
						<input type="time" id="time_initial" name="time_initial"  class="form-control"  placeholder="Horário Final" required>
					</div>
				</div>
			</div>
					
			<div class="form-row">
				<div class="form-group">
					<div class="col-md-6">
						<label for="date_final">Data da Manutenção Final</label>
						<input type="date" id="date_final" name="date_final"  class="form-control"  placeholder="Data Final" required>
					</div>
					<div class="col-md-6">
						<label for="time_final">Horário da Manutenção Final</label>
						<input type="time" id="time_final" name="time_final"  class="form-control" id="time_final" placeholder="Hora Final" required>
					</div>
				</div>
			</div>
			
			<div class="form-row">
				<div class="form-group">
					<div class="col-md-12">
						<label for="annotations">Anotações</label>
						<textarea type="text" class="form-control" id="annotations" name="annotations" placeholder="Anotações"></textarea>
					</div>
				</div>
			</div>	
			
			<div class="form-row" >
				<div class="form-group">
					<div class="col-md-12">
						<label for="collaborator_name" >Manutenção Realizada Por:</label>
						<select name="collaborator_name" id="collaborator_name"   class="form-control">
							<?php foreach($employees as $employee): ?>	
							<option value="<?=$employee->name; ?>"><?=  $employee->name;?></option>
							<?php endforeach; ?>
						</select>
					</div>	
				</div>		
			</div>	
									
			<div class="form-row">
				<div class="form-group">
					<div class="col-md-12">
						<label for="status_id">Estado do Serviço</label>
						<select name="status_id" id="status_id" class="form-control" required>
							<?php foreach($statuses as $statuse):?>
							<option value="<?php echo $statuse->id; ?>"><?php echo $statuse->name; ?></option>
							<?php endforeach; ?>
						</select>
					</div>		
				</div>		
			</div>
			
			<div class="form-row">
				<div class="form-group">
					<div class="col-lg-12">
						<label for="price">Custo Total da Manutenção</label>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-usd"></i></span>
							<input type="text" id="price" class="form-control" name="price" placeholder="Custo Total da Manutenção">
						</div>
					</div>
				</div>	
			</div>
			
			<div class="form-row">
				<div class="form-group">
					<div class="col-lg-12">
						<button class="btn btn-primary">Agendar Manutenção</button>
					</div>
				</div>
			</div>	
			
		</form>
		
		
		<form id="external" style="display:none;" class="form-horizontal"  action="<?= url("/app/maintenance-add"); ?>" method="post">
			<input type="hidden" name="action" value="create"/>	
			<input type="hidden" name="type_collaborator" value="external_collaborator"/>	
			<div class="form-row">
				<div class="form-group">
					<div class="col-md-12">
						<label for="maintenance_type">Tipo de Manutenção</label>
						<select name="maintenance_type" id="maintenance_type"  class="form-control" required>
							<option value="">SELECIONE TIPO DE MANUTENÇÃO</option>
							<option value="Manutenção Preventiva">MANUTENÇÃO PREVENTIVA</option>
							<option value="Manutenção Correntiva">MANUTENÇÃO CORRENTIVA</option>
							<option value="Manutenção Preditiva">MANUTENÇÃO PREDITIVA</option>
						</select>
					</div>
				</div>
			</div>
				
			<div class="form-row">
				<div class="form-group">
					<div class="col-md-12">
						<label for="equipment_id">Equipamento</label>
						<select name="equipment_id" id="equipment_id" class="form-control" required>
							<option value="">SELECIONE</option>
							<?php foreach($equipments as $equipment):?>
							<option value="<?php echo $equipment->id; ?>"><?php echo $equipment->id." - ".$equipment->name?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
			</div>
				
			<div class="form-row">
				<div class="form-group">
					<div class="col-md-12">
						<label for="service_id">Tipo de Serviço:</label>
						<select name="service_id" id="service_id"  class="form-control" required>
							<option value="">SELECIONE TIPO DE SERVIÇO</option>
							<?php foreach($services as $service):?>
							<option value="<?php echo $service->id;?>"><?php echo $service->name?></option>
							<?php endforeach; ?>			
						</select>
					</div>
				</div>
			</div>
					
			<div class="form-row">
				<div class="form-group">
					<div class="col-md-6">
						<label for="date_initial">Data da Manutenção Inicial</label>
						<input type="date" id="date_initial" name="date_initial"  class="form-control" id="date_initial" placeholder="Data Inicial" required>
					</div>
				
					<div class="col-md-6">
						<label for="time_initial">Horário  da Manutenção Inicial</label>
						<input type="time" id="time_initial" name="time_initial"  class="form-control"  placeholder="Horário Final" required>
					</div>
				</div>
			</div>
					
			<div class="form-row">
				<div class="form-group">
					<div class="col-md-6">
						<label for="date_final">Data da Manutenção Final</label>
						<input type="date" id="date_final" name="date_final"  class="form-control"  placeholder="Data Final" required>
					</div>
				
					<div class="col-md-6">
						<label for="time_final">Horário da Manutenção Final</label>
						<input type="time" id="time_final" name="time_final"  class="form-control" id="time_final" placeholder="Hora Final" required>
					</div>
				</div>
			</div>
			
			<div class="form-row">
				<div class="form-group">
					<div class="col-md-12">
						<label for="annotations">Anotações</label>
						<textarea type="text" class="form-control" id="annotations" name="annotations" placeholder="Anotações"></textarea>
					</div>
				</div>
			</div>


			<div class="form-row" >
				<div class="form-group">
					<div class="col-md-12">
						<label for="collaborator_name" >Manutenção Realizada Por:</label>
						<select name="collaborator_name" id="collaborator_name"   class="form-control">

							<?php foreach($suppliers as $supplier): ?>
							
							<option value="<?=$supplier->name; ?>"><?=  $supplier->name;?></option>

							<?php endforeach; ?>
							
						</select>							
					</div>	
				</div>		
			</div>	
							
			<div class="form-row">
				<div class="form-group">
					<div class="col-md-12">
						<label for="status_id">Estado do Serviço</label>
						<select name="status_id" id="status_id" class="form-control" required>
							<?php foreach($statuses as $statuse):?>
							<option value="<?php echo $statuse->id; ?>"><?php echo $statuse->name; ?></option>
							<?php endforeach; ?>
						</select>
					</div>		
				</div>		
			</div>
			
			<div class="form-row">
				<div class="form-group">
					<div class="col-lg-12">
						<label for="price">Custo Total da Manutenção</label>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-usd"></i></span>
							<input type="text" id="price" class="form-control" name="price" placeholder="Custo Total da Manutenção">
						</div>
					</div>
				</div>	
			</div>
			<br></br>			
			<div class="form-row">
				<div class="form-group">
					<div class="col-lg-12">
						<button class="btn btn-primary">Agendar Manutenção</button>
					</div>
				</div>
			</div>
			
			
	
		</form>
	
	</div>

</div>



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







