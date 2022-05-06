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
                <h3 class="dashhead-title">Lista de Manutenções</h3>
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
					<a href="<?= url("/app/maintenance-add"); ?>" class="btn btn-primary">Nova Manutenção</a>
                  </div>
                </header>
			  
			  
					<form class="form-horizontal" role="form" action="<?= url("/app/maintenancesearch"); ?>" method="post" enctype="multipart/form-data">
						<input type="hidden" name="maintenancesearch" value="maintenance">
										
											<div class="col-md-3">
												<label for="service_id">Escolha um Serviço</label>
												<div class="input-group">	
													<span class="input-group-addon"><i class="fa fa-fw fa-male"></i></span>
													<select id="service_id" name="service_id" class="form-control">									
														<option value="all">Todas</option>
														<?php foreach ($services as $service): ?>
														<option <?= (!empty($filter->service_id) && $filter->service_id == $service->id ? "selected" : ""); ?>
														value="<?= $service->id; ?>"><?= $service->name; ?></option>
														<?php endforeach; ?>						
													</select>
												</div>
											</div>
											<div class="col-md-3">
												<label for="equipment_id">Escolha um Equipamento</label>
												<div class="input-group">
													<span class="input-group-addon"><i class="fa fa-fw fa-male"></i></span>
													<select id="equipment_id" name="equipment_id" class="form-control">
														<option value="all">Todas</option>
														<?php foreach ($equipments as $equipment): ?>
														<option <?= (!empty($filter->equipment_id) && $filter->equipment_id == $equipment->id ? "selected" : ""); ?>
														value="<?= $equipment->id; ?>"><?= $equipment->name; ?></option>
														<?php endforeach; ?>	
													</select>
												</div>
											</div>
											<div class="col-md-3">
												<label for="date">Escolha uma Data</label>
												<div class="input-group"> 
													<span class="input-group-addon"><i class="fa fa-fw fa-calendar"></i></span>
													<input id="date" value="date" type="date" name="date" class="form-control" placeholder="<?= (!empty($filter->date) ? $filter->date : "all"); ?>">
												</div>
											</div>
											
											<div class="col-md-2">
													<label for=""></label>
													<button class="btn btn-primary btn-block">Buscar</button>
											</div>	
					</form>
					  
				
                <div class="box-body">
                  <table id="datatables" class="table table-striped table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                        <th>Equipamento</th>
						<th>Tipo de Serviço</th>
					    <th>Manutenção Realizada Por</th>
						<th>Tipo de Colobarador</th>
						<th>Data</th>
						<th>Horario da Manutenção</th>

						<th>Ações</th>
                      </tr>
                    </thead>
                    <tfoot>
                    
                    </tfoot>
                    <tbody>
						<?php if (!empty($maintenances)): ?>
						<?php foreach ($maintenances as $maintenance):?>
						<?php $equipment  = $maintenance->getEquipment();?>
						<?php $service  = $maintenance->getService();?>
						<?php $teste  = $maintenance->type_collaborator;?>
						<tr>
							<td><?php echo $equipment->name; ?></td>
							<td><?php echo $service->name; ?></td>
							<td><?php echo $maintenance->getOccupation($teste);?></td>
							<td><?php echo $maintenance->getTypeCollaborator($teste);?></td>
							<td><?php echo date_fmt($maintenance->date_initial, "d/m/Y");?></td>
							<td><?php echo $maintenance->time_initial;?></td>

							<td style="width:180px;">				
							<a href="<?= url("/app/maintenance-edit/{$maintenance->id}"); ?>" class="btn btn-warning btn-xs">Editar</a>
							<a class="btn-simple btn btn-danger btn-xs" title="" href="#"
                                   data-post="<?= url("/app/maintenance-delete/{$maintenance->id}"); ?>"
                                   data-action="delete"
                                   data-confirm="Tem Certeza que Deseja Deletar essa Manutenção?"
                                   data-id="<?= $maintenance->id;?>">Deletar</a>  
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
				
		

