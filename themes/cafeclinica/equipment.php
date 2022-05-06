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
                <h3 class="dashhead-title">Lista de Equipamentos</h3>
              </div>

              <div class="dashhead-toolbar">
                <div class="dashhead-toolbar-item">
					teste
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
					<div class="dashhead bg-white">
						<div class="dashhead-titles">
							<a href="<?= url("/app/equipment-add"); ?>" class="btn btn-primary"><i class='fa fa-fw fa-support'></i>Novo Equipamento</a>

						</div>
					</div>
					
					<div class="dashhead bg-white">
						<form class="form-horizontal" action="<?= url("/app/equipment"); ?>">
							<div class="icon-after-input">
								<input type="text" name="s" value="<?=$search;?>" class="form-control" placeholder="Search">
									<button class="icon">
										<i class="fa fa-fw fa-search"></i>
									</button>	
							</div>
						</form>
					</div>
                </header>
		
                <div class="box-body">
                  <table id="datatables" class="table table-striped table-bordered" width="100%" cellspacing="0">
                    <thead>
                     <tr>
                        <th>Equipamento</th>
						<th>Tipo de Equipamento</th>
						<th>Localização</th>
						<th>Tagueamento</th>
						<th>Ação</th>
                      </tr>
                    </thead>
                    <tfoot>
             
                    </tfoot>
                    <tbody>
						<?php if (!empty($equipments)): ?>
						<?php foreach ($equipments as $equipment):?>
						<tr>
							<td><?php echo $equipment->name;?></td>
							<td><?php echo $equipment->getCategory()->name; ?></td>
							<td><?php echo $equipment->localization; ?></td>
							<td><?php echo $equipment->tag; ?></td>
							
							<td style="width:280px;">
							<a href="<?= url("/app/equipment-edit/{$equipment->id}"); ?>" class="btn btn-warning btn-xs">Editar</a>
							<a class="btn btn-danger btn-xs" title="" href="#"
                                   data-post="<?= url("/app/equipment");  ?>"
                                   data-action="delete"
                                   data-confirm="Tem Esse Equipamento"
                                   data-id="<?= $equipment->id; ?>">Deletar</a>						
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
				
		


		



