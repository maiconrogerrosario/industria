<?php $v->layout("_theme"); ?>

 <!-- begin .app-main -->
        <div class="app-main">

          <!-- begin .main-heading -->
          <header class="main-heading shadow-2dp">
            <!-- begin dashhead -->
            <div class="dashhead bg-white">
              <div class="dashhead-titles">

                <h3 class="dashhead-title">Serviços</h3>
				<h6 class="dashhead-subtitle p-t-15">
                  <a href="index.html">chaldene</a>
                  / forms
                  / Form Wizard
                </h6>
              </div>

              <div class="dashhead-toolbar ">
                <div class="dashhead-toolbar-item p-t-30">
                  <a href="index.html">chaldene</a>
                  / forms
                  / Form Wizard
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
                      <h4>Cadastro de Etapas<small></small> </h4>
                      <!-- begin box-tools -->
                      <!--<div class="box-tools">
                        <a class="fa fa-fw fa-minus" href="#" data-box="collapse"></a>
                        <a class="fa fa-fw fa-times" href="#" data-box="close"></a>
                      </div>-->
                      <!-- END: box-tools -->
                    </header>
                    <div class="box-body">
                      <form class="form-horizontal" id="example-form" action="#">
                        <div>
							<section>
								<div class="form-group">
									<div class="col-md-12">
										<label  for="service_id">Escolha a Obra</label>
										<select name="service_id" id="service_id"  class="form-control" required>
											<option value="">SELECIONE TIPO DE SERVIÇO</option>
											<?php foreach($works as $work):?>
											<option value="<?php echo $work->id;?>"><?php echo $work->name?></option>
											<?php endforeach; ?>			
										</select>
									</div>
								</div>						
								<div class="form-group">
									<div class="col-md-12">
										<label  for="service_id">Tipo de Etapa:</label>
										<select name="service_id" id="service_id"  class="form-control" required>
											<option value="">SELECIONE TIPO DE SERVIÇO</option>
											<?php foreach($stages as $stage):?>
											<option value="<?php echo $stage->id;?>"><?php echo $stage->name?></option>
											<?php endforeach; ?>			
										</select>
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-6">
										<label for="date_initial">Data de Ínicio dessa Etapa</label>
										<span class="fa fa-question-circle stage-visibled" data-toggle="tooltip" data-placement="bottom" title="Define a data de inicío PREVISTO dessa etapa"></span>
										<input type="date" id="date_initial" name="date_initial"  class="form-control" id="date_initial" placeholder="Data Inicial" required>
									</div>
							
									<div class="col-md-6">
										<label for="date_final">Data  Final dessa Etapa</label>
											<span class="fa fa-question-circle stage-visibled" data-toggle="tooltip" data-placement="bottom" title="Define a data de fim PREVISTO dessa etapa"></span>
										<input type="date" id="date_final" name="date_final"  class="form-control" id="date_final" placeholder="Data Final" required>
									</div>	
								</div>
							
								<div class="form-group">
									<div class="col-md-12">
										<label for="duration">Duração:</label>
										<input type="text" class="form-control" id="duration" name="duration" placeholder="Duração"/>
									</div>
								</div>	
								<div class="form-group">
									<div class="col-md-12">
									<button class="btn btn-primary">Cadastrar Etapa</button>
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
          <footer class="main-footer bg-white p-a-5">
           
          </footer>
          <!-- END: .main-footer -->

        </div>
        <!-- END: .app-main -->	

