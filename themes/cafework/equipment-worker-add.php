<?php $v->layout("_theme"); ?>

 <div class="main-content bg-clouds">
    <!-- begin .container-fluid -->
    <div class="container-fluid p-t-15">
        <div class="box">
            <header class="bg-primary">
				<h4>Criar Vinculação do Usuário</h4>
            </header>	
		</div>
	
		<form class="form-horizontal" action="<?= url("/app/equipment-worker-add"); ?>" method="post">
			<input type="hidden" name="action" value="create"/>	
				
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
			
			<div class="form-row" >
				<div class="form-group">
					<div class="col-md-12">
						<label for="employee_id" >Funcionário:</label>
						<select name="employee_id" id="employee_id"   class="form-control">
							<?php foreach($employees as $employee): ?>	
							<option value="<?=$employee->id; ?>"><?=  $employee->name;?></option>
							<?php endforeach; ?>
						</select>
					</div>	
				</div>		
			</div>
			
			<div class="form-row" >
				<div class="form-group">
					<div class="col-md-12">
						<label for="status" >Status:</label>
						<select name="status" id="status"   class="form-control">	
							<option value="ATIVO">VINCULAÇÃO ATIVA</option>
							<option value="INATIVO">VINCULAÇÃO INATIVA</option>
						</select>
					</div>	
				</div>		
			</div>
			
			<div class="form-row">
				<div class="form-group">
					<div class="col-md-12">
						<label for="observation">Observaçãoes:</label>
						<textarea type="text" class="form-control" id="observation" name="observation" placeholder="observaçãoes"></textarea>
					</div>
				</div>
			</div>	
		
			<div class="form-row">
				<div class="form-group">
					<div class="col-lg-12">
						<button class="btn btn-primary">Cadastrar Vinculação</button>
					</div>
				</div>
			</div>	
			
		</form>
		
	</div>

</div>









