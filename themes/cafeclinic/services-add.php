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
                      <h4>Cadastro de Clientes<small></small> </h4>
                      <!-- begin box-tools -->
                      <!--<div class="box-tools">
                        <a class="fa fa-fw fa-minus" href="#" data-box="collapse"></a>
                        <a class="fa fa-fw fa-times" href="#" data-box="close"></a>
                      </div>-->
                      <!-- END: box-tools -->
                    </header>
                    <div class="box-body">
                      <form class="form-horizontal" action="<?= url("/work/customer-add"); ?>" method="post">
                        <div>
							<section>
								<div class="form-group">
									<div class="col-md-12">
										<input type="hidden" name="action" value="create"/>
										<label for="sername">Nome do Serviço</label> 
										<input type="text" class="form-control" id="sername" name="sername" placeholder="Nome do Serviço" value="" required="true"> 
									</div>
								</div>
							
								<div class="form-group">
									<div class="col-md-12">
										<label for="cost">Preço do Serviço</label>
										<input type="cost" class="form-control" id="cost" placeholder="Preço" name="cost"/>
									</div>
								</div>
								
								<div class="form-group">
									<div class="col-md-12">
									<button class="btn btn-primary">Cadastrar Serviço</button>
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




