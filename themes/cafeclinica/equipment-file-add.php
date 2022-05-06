<?php $v->layout("_theme"); ?>

 <div class="main-content bg-clouds">
    <!-- begin .container-fluid -->
    <div class="container-fluid p-t-15">
        <div class="box">
            <header class="bg-primary">
				<h4>Cadastrar Novo Documento</h4>
            </header>	
		</div>
	
		<form class="form-horizontal" action="<?= url("/app/equipment-file-add"); ?>" method="post">
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
			
			<div class="form-row">
				<div class="form-group">
					<div class="col-md-12">
						<label for="title">Título do Documento</label>
						<input type="text" class="form-control" id="title" name="title" placeholder="Título do Documento" required/>
					</div>
				</div>
			</div>
				
			<div class="form-row">
				<div class="form-group">
					<div class="col-md-12">
						<label for="subtitle">Subtítulo do Documento</label>
						<input type="text" class="form-control" id="subtitle" name="subtitle" placeholder="Subtítulo do Documento" />
					</div>
				</div>
			</div>
			
			<div class="form-row">
				<div class="form-group">
					<div class="col-md-12">
						<label for="cover">Inserir Documento</label>
						<input type="file" class="form-control" name="cover" placeholder="Inserir Documento" required/>
					</div>
				</div>
			</div>
		
			<div class="form-row" >
				<div class="form-group">
					<div class="col-md-12">
						<label for="status" >Status</label>
						<select name="status" id="status"   class="form-control" required>	
							<option value="ATIVO">Documento Ativo</option>
							<option value="INATIVO">Documento Inativo</option>
						</select>
					</div>	
				</div>		
			</div>
			
			<div class="form-row">
				<div class="form-group">
					<div class="col-md-12">
						<label for="description">Descrição do Arquivo</label>
						<textarea class="form-control" name="description" placeholder="Descrição"></textarea>
					</div>
				</div>
			</div>	
		
			<div class="form-row">
				<div class="form-group">
					<div class="col-lg-12">
						<button class="btn btn-primary">Cadastrar Novo Documento</button>
					</div>
				</div>
			</div>		
		</form>	
	</div>
</div>









