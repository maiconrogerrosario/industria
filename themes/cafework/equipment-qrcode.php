<?php $v->layout("_theme"); ?>

 <!-- begin .app-main -->
        <div class="app-main">
		
          <!-- begin .main-heading -->
          <header class="main-heading shadow-2dp">
            <!-- begin dashhead -->
            <div class="dashhead bg-white">
              <div class="dashhead-titles">
                <h6 class="dashhead-subtitle">
                 
                </h6>
                <h3 class="dashhead-title">Lista de QR Code dos Equipamentos</h3>
              </div>

              <div class="dashhead-toolbar">
                <div class="dashhead-toolbar-item">
					
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
              <div class="box">
				<header>
                  <div class="form-horizontal">
					<a href="<?= url("/app/equipment-qrcode-add"); ?>" class="btn btn-primary">Novo QR Code</a>
                  </div>
                </header>
                <div class="box-body">
                  <table id="datatables" class="table table-striped table-bordered" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                       <th>id</th>	
					   <th>Nome do equipamento</th>
					   <th>Status</th>
					   <th>Ações</th>
                      </tr>
                    </thead>
                    <tfoot>
                      
                    </tfoot>
                    <tbody>
						<?php if (!empty($equipmentQrcodes)): ?>
						<?php foreach ($equipmentQrcodes as $equipmentQrcode):?>
						<?php $equipment  = $equipmentQrcode->getEquipment();?>
		
						<tr>			
							<td><?php echo $equipmentQrcode->id;?></td>
							<td><?php echo $equipment->name; ?></td>
							<td><?php echo $equipmentQrcode->status; ?></td>			
							<td style="width:150;">	
							<a href="<?= url("/app/equipment-qrcode-edit/{$equipmentQrcode->id}"); ?>" class="btn btn-warning btn-xs">Editar</a>	
							<a class="btn btn-danger btn-xs"   title="" href="#"
                                   data-post="<?= url("/app/equipment-qrcode-delete/{$equipmentQrcode->id}"); ?>"
                                   data-action="delete"
                                   data-confirm="Tem que deseja deletar essa vinculação?"
                                   data-id="<?=$equipmentQrcode->id;?>"><i class="fa fa-remove p-r-5"></i>Deletar</a>  
								
							<a href="<?=$equipmentQrcode->info;?>" class="btn btn-primary btn-xs"><i class="fa fa-download p-r-5"></i>Qrcode Info</a>
							<a href="<?= $equipmentQrcode->support;?>" class="btn btn-primary btn-xs"><i class="fa fa-download p-r-5"></i>Qrcode support</a>	   
							
							</td>				
						</tr>						
						<?php endforeach; ?>
						<?php endif; ?>		    
                    </tbody>
                  </table>  
                </div>
              </div>

            </div>
            <!-- END: .container-fluid -->

          </div>
          <!-- END: .main-content -->

          <!-- begin .main-footer -->
          <footer class="main-footer bg-white p-a-5">
		  
			 <?=$paginator?>
			 
          </footer>
          <!-- END: .main-footer -->

        </div>
				
		

