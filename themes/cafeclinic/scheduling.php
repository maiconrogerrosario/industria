<?php $v->layout("_theme"); ?>

 <!-- begin .app-main -->
        <div class="app-main">

          <!-- begin .main-heading -->
          <header class="main-heading shadow-2dp">
            <!-- begin dashhead -->
            <div class="dashhead bg-white">
              <div class="dashhead-titles">

                <h3 class="dashhead-title">Agendamentos</h3>
				<h6 class="dashhead-subtitle p-t-15">
                  <a href=""></a>
                </h6>
              </div>

              <div class="dashhead-toolbar ">
                <div class="dashhead-toolbar-item p-t-30">
                  <a href=""></a>
                 
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
                      <h4>Agendamento<small></small> </h4>
                      <!-- begin box-tools -->
                      <!--<div class="box-tools">
                        <a class="fa fa-fw fa-minus" href="#" data-box="collapse"></a>
                        <a class="fa fa-fw fa-times" href="#" data-box="close"></a>
                      </div>-->
                      <!-- END: box-tools -->
                    </header>
                    <div class="box-body">
						<a type="button" title="Editar" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#scheduling"></a>	
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

						<!-- Modal Task Add -->
							<div class="modal fade" id="scheduling" tabindex="-1" role="dialog" aria-labelledby="addScheduling">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											<h4 class="modal-title" id="addScheduling">Novo Agendamento</h4>
										</div>
										<div class="modal-body">																		
											<form  action="<?= url("/work/modaltask");?>" method="post">
												<div class="form-group">
													<div class="col-md-6">
														<label for="task_name">Nome do Cliente:</label>
														<input type="text" id="task_name" name="task_name"  class="form-control" placeholder="Nome do Serviço:" required>
													</div>
													<div class="col-md-6">
														<label for="task_name">Telefone:</label>
														<input type="text" id="task_name" name="task_name"  class="form-control" placeholder="Nome do Serviço:" required>
													</div>	
													
												</div>	
												<div class="form-group">
													<div class="col-md-6">
														<label for="stage_name">Profissional:</label>
														<select name="stage_id" id="stage_id"   class="form-control">
															<?php foreach($stage as $stageListAdd): ?>
																<option value="<?=$stageListAdd->id;?>"><?= $stageListAdd->stage_name;?></option>
															<?php endforeach; ?>
														</select>
													</div>
													<div class="col-md-6">
														<label for="stage_name">Procedimentos:</label>
														<select name="stage_id" id="stage_id"   class="form-control">
															<?php foreach($stage as $stageListAdd): ?>
																<option value="<?=$stageListAdd->id;?>"><?= $stageListAdd->stage_name;?></option>
															<?php endforeach; ?>
														</select>
													</div>	
												</div>
												<div class="form-group">
													<div class="col-md-6">
														<label for="date_initial">Data</label>
														<input type="date" id="date_initial" name="date_initial"  class="form-control" id="date_initial" placeholder="Data Inicial" required>
													</div>
													<div class="col-md-3">
														<label for="time_initial">Hora Início</label>
														<input type="time" id="time_initial" name="time_initial"  class="form-control"  placeholder="Horário Final" required>
													</div>
													<div class="col-md-3">
														<label for="time_initial">Hora Fim</label>
														<input type="time" id="time_initial" name="time_initial"  class="form-control"  placeholder="Horário Final" required>
													</div>
												</div>
												<div class="form-group">
													<div class="col-md-12">
														<label for="annotations">Motivo da Consulta</label>
														<textarea type="text" class="form-control" id="annotations" name="annotations" placeholder="Anotações"></textarea>
													</div>	
												</div>																					
												<div class="form-group p-a-15 ">
													<button  class="btn btn-primary m-t-15">Cadastrar</button>
												</div>								
											</form>	
										</div>
									</div>
								</div>
							</div>
		

