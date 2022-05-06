<?php $v->layout("_theme"); ?>

 <div class="main-content bg-clouds">
    <!-- begin .container-fluid -->
    <div class="container-fluid p-t-15">
        <div class="box">
            <header class="bg-primary">
				<h4>Criar QR Code Equipamento</h4>
            </header>	
		</div>
	
		<form class="form-horizontal" action="<?= url("/app/equipment-qrcode-edit/{$qrcodeEdit->id}"); ?>" method="post">
			<input type="hidden" name="action" value="update"/>	
	
			<div class="form-row">
				<div class="form-group">
					<div class="col-md-12">
						<label for="equipment_id">Equipamento</label>
						<select name="equipment_id" id="equipment_id" class="form-control" required>
				
							<option value="<?php echo $qrcodeEdit->equipment_id; ?>"><?php echo $qrcodeName->name;?></option>
							
					
						</select>
					</div>
				</div>
			</div>
			
			<div class="form-row" >
				<div class="form-group">
					<div class="col-md-12">
						<label for="status" >Status</label>
						<select name="status" id="status"   class="form-control" required>	
						       <option <?= ($qrcodeEdit->status == "ATIVO" ? "selected" : ""); ?> value="ATIVO">QR Code Ativo</option>
							   <option <?= ($qrcodeEdit->status == "INATIVO" ? "selected" : ""); ?> value="INATIVO">QR Code INATIVO</option>
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









