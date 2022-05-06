<?php $v->layout("_theme"); ?>

 <div class="main-content bg-clouds">
    <!-- begin .container-fluid -->
    <div class="container-fluid p-t-15">
        <div class="box">
            <header class="bg-primary">
				<h4>Criar QR Code Equipamento</h4>
            </header>	
		</div>
	
		<form class="form-horizontal" action="<?= url("/app/equipment-qrcode-add"); ?>" method="post">
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
						<label for="status" >Status</label>
						<select name="status" id="status"   class="form-control" required>	
							<option value="ATIVO">QR Code Ativo</option>
							<option value="INATIVO">QR Code Inativo</option>
						</select>
					</div>	
				</div>		
			</div>
		
			<div class="form-row">
				<div class="form-group">
					<div class="col-lg-12">
						<button class="btn btn-primary">Gerar QR Code</button>
					</div>
				</div>
			</div>		
		</form>	
	</div>
</div>









