<?php $v->layout("_theme"); ?>

<div class="app-main">
    <!-- begin .main-heading -->
    <header class="main-heading shadow-2dp">
		<!-- begin dashhead -->
		<div class="dashhead bg-white">
			<div class="dashhead-titles">
				<h6 class="dashhead-subtitle">
					chaldene
					/ tables
				</h6>
				<h3 class="dashhead-title">Table Basic</h3>
			</div>
			<div class="dashhead-toolbar">
				<div class="dashhead-toolbar-item">
					<a href="index.html">chaldene</a>
					/ tables
					/ Table Basic
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
            <!-- BEGIN: .row -->
            <div class="row">
                <div class="col-md-12">
					<div class="box shadow-2dp">
						<header>
							<span class="fa fa-bar-chart"></span>
							<h4>Detalhes da Obra ou Serviços</h4>
							<!-- begin box-tools -->
							<!-- <div class="box-tools">
							<a class="fa fa-fw fa-minus" href="#" data-box="collapse"></a>
							<a class="fa fa-fw fa-times" href="#" data-box="close"></a>
							</div>-->
							<!-- END: box-tools -->
						</header>
						<div class="box-body" style="">
							<table class="table table-striped" align="left"  width="100%">		
								<tbody>
									<tr>
										<tr>
											<td><strong>Nome da Obra ou Serviço</strong></td><td align="left"><?php echo $project->name;?>
										</tr>
										<tr>
											<td><strong>Data Inicial:</strong></td><td><?php echo $project->date_initial;?>
										</tr>
										<tr>
											<td><strong>Data Final:</strong></td><td><?php echo $project->date_final;?>
										</tr>
										<tr>
											<td><strong>Status da Obra ou Serviço</strong></td><td><?php if($project->status == "active"){
												echo "ATIVO";
											}else{
												echo "INATIVO";
												
											}?>                    
										</tr>
										
										
										
									</tr>	
								</tbody>								
							</table>
						</div>
					</div>	
				</div>
				<div class="col-sm-12">
					<div class="box">
							<header>
								<h3>Tabs</h3>
							</header>
						<div class="box-body">
							<ul class="nav nav-tabs">
								<li class="active">
									<a href="#z1" data-toggle="tab" aria-expanded="true">Cronograma</a>
								</li>
								<li class="">
									<a href="#z2" data-toggle="tab" aria-expanded="false">Etapas</a>
								</li>
								<li class="">
									<a href="#z3" data-toggle="tab" aria-expanded="false">Tarefas</a>
								</li>
							</ul>
							<!-- Cronograma -->
							<div class="tab-content">
								<div id="z1" class="tab-pane fade active in">	
									<div class="col-md-12">
										<div class="box">
											<header>
												<h4>Cronograma</h4>
												
												<!-- begin box-tools -->
												<div class="box-tools  p-a-5">
													<button class="btn btn-block btn-primary btn-rect text-uppercase" title="Cadastrar Etapa" data-toggle="modal" data-target="#stageAddModal">
														Etapa
													</button>
													
												</div>
												
												<div class="box-tools p-a-5">
													
													<button class="btn btn-block btn-primary btn-rect text-uppercase" title="Cadastrar Tarefa" data-toggle="modal" data-target="#taskAddModal">
														Tarefa
													</button>
												
												</div>
												
												
												<!-- END: box-tools -->
											</header>
											<div class="box-body collapse in" id="box1">
												<table class="table table-bordered table-hover m-t-a">
												
													<thead>
														<th scope="col" style="text-align:center;">Tipo</th>
														<th scope="col"style="text-align:center;">Descrição</th>
														<th scope="col" style="text-align:center;">Data de Início</th>
														<th scope="col" style="text-align:center;">Data de Términio</th>
														<th scope="col" style="text-align:center;">Prazo</th>
														<th scope="col" style="text-align:center;">Status</th>
														<th scope="col" style="text-align:center;">Ações</th>	
													</thead>
													<tbody>
														
														
													<?php if (!empty($stage)): ?>		
													<?php foreach ($stage as $stage1):?>	
															<thead>
																<th scope="col" style="text-align:center;">Fase</th>
																<th scope="col"style="text-align:center;"><?php echo  $stage1->stage_name;?></th>
																<th scope="col" style="text-align:center;"><?php echo $stage1->date_initial;?></th>
																<th scope="col" style="text-align:center;"><?php echo $stage1->date_final;?></th>
																<th scope="col" style="text-align:center;"><?php echo $stage1->duration;?></th>
												
																<th scope="col" style="text-align:center;"><?php if($stage1->status == "active"){
																	
																	echo "ATIVO";
																	
																	}else{
																		
																	echo "INATIVO";
												
																	}?>
																	
																</th>
																<th scope="col" style="text-align:center;font-size:12px;">
																	<a title="Visualizar Etapa" class="btn btn-primary btn-xs"><span class="fa fa-file-o fw-fa"></span></a>
																	<a type="button" title="Editar"  class="btn btn-warning btn-xs" 
																		data-toggle="modal" data-target="#stageEditModal1<?php echo $stage1->id;?>"
																	><span class="fa fa-edit fw-fa"></span></a>

																	<a title="Deletar" class="btn-simple btn btn-danger btn-xs" title="" href="#"
																		data-post="<?= url("/work/modalstage/{$stage1->id}"); ?>"
																		data-action="delete"
																		data-confirm="Tem Certeza que Deseja Deletar essa Etapa?"
																		data-id="<?= $stage1->id; ?>"><span class="fa fa-remove fw-fa"></span></a>
																</th>
															</thead>
															<div class="modal fade" id="stageEditModal1<?php echo $stage1->id;?>" tabindex="-1" role="dialog" aria-labelledby="stageModalEdit">
																<div class="modal-dialog" role="document">
																	<div class="modal-content">
																		<div class="modal-header">
																			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
																			<h4 class="modal-title" id="stageModalEdit">Alterar Etapa</h4>
																		</div>
																		<div class="modal-body">																		
																			<form  action="<?= url("/work/modalstage"); ?>" method="post">	
																				<div class="form-group">
																					<div class="col-md-12">
																						<label for="stage_name">Etapa:</label>
																						<input type="hidden" name="action" value="update"/>
																						<input type="hidden" name="id" value="<?= $stage1->id;?>"/>
																						<input type="hidden" name="work" value="<?php echo $project->id;?>"/>
																						<select name="stage_name" id="stage_name"   class="form-control">
																							<?php foreach ($stageCategory as $stageCategoryList1): ?>
																								<option value="<?php echo $stageCategoryList1->name; ?>" <?php if($stage1->stage_name==$stageCategoryList1->name){ echo "selected"; }?>><?php echo $stageCategoryList1->name;?></option> 
																							<?php endforeach;?>
																						</select>
																					</div>	
																				</div>
																				<div class="form-group">
																					<div class="col-md-6">
																						<label for="name">Data de Início da Etapa:</label>
																						<input value="<?= $stage1->date_initial;?>" type="date" id="date_initial" name="date_initial"  class="form-control" placeholder="Data Inicial" required>
																					</div>
																					<div class="col-md-6">
																						<label for="date_final">Data de Entrega da Etapa:</label>
																						<input value="<?= $stage1->date_final;?>" type="date" id="date_final" name="date_final"  class="form-control"  placeholder="Data Final" required>
																					</div>	
																				</div>		
																				<div class="form-group">
																					<div class="col-md-12">
																						<label for="status">Estado da Etapa:</label>
																						<select name="status" id="status" class="form-control" required>
																							<?php
																								$status = $stage1->status;
																								$select = function ($value) use ($status) {
																								return ($status == $value ? "selected" : "");
																								};
																							?>
																							<option <?= $select("active"); ?> value="active">Ativa</option>
																							<option <?= $select("finished"); ?> value="finished">Finalizada</option>
																						</select>
																					</div>	
																				</div>
																				<div class="form-group">
																					<div class="col-md-12">
																						<label for="annotations">Anotações</label>
																						<textarea type="text" class="form-control" id="annotations" name="annotations" placeholder="<?= $stage1->annotations;?>"></textarea>
																					</div>	
																				</div>													
																				<div class="form-group p-a-15 ">
																					<button   class="btn btn-primary m-t-15">Alterar</button>
																				</div>																	
																			</form>
																		</div>
																	</div>
																</div>
															</div>	         	
															
														<?php if (!empty($tasks)): ?>				
														<?php foreach ($tasks as $task1):?>	
													
														<?php if ($stage1->id ==  $task1->stage_id): ?>
															<tr scope="row">
																<td scope="col" style="text-align:center;">SubFase</td>
																<td scope="col" style="text-align:center;"><?php echo $task1->task_name;?></td>
																<td scope="col" style="text-align:center;"><?php echo $task1->date_initial;?></td>
																<td scope="col" style="text-align:center;"><?php echo $task1->date_final;?></td>
																<td scope="col" style="text-align:center;"><?php echo $task1->duration;?></td>
																<td scope="col" style="text-align:center;"><?php if($task1->status == "active"){
																	
																	echo "ATIVO";
																	
																	}else{
																		
																	echo "INATIVO";
												
																	}?>
																	
																</td>
																<td scope="col" style="text-align:center;font-size:12px;">
																	<a title="Visualizar Etapa" class="btn btn-primary btn-xs"><span class="fa fa-file-o fw-fa"></span></a>
																	<a type="button" title="Editar"  class="btn btn-warning btn-xs" 
																		data-toggle="modal" data-target="#taskEditModal1<?php echo $task1->id;?>"
																	><span class="fa fa-edit fw-fa"></span></a>

																	<a title="Deletar" class="btn-simple btn btn-danger btn-xs" title="" href="#"
																		data-post="<?= url("/work/modaltask/{$task1->id}"); ?>"
																		data-action="delete"
																		data-confirm="Tem Certeza que Deseja Deletar essa Tarefa?"
																		data-id="<?= $task1->id;?>"><span class="fa fa-remove fw-fa"></span></a>
																</td>

																
															<div class="modal fade" id="taskEditModal1<?php echo $task1->id;?>" tabindex="-1" role="dialog" aria-labelledby="taskModalEdit1">
																<div class="modal-dialog" role="document">
																	<div class="modal-content">
																		<div class="modal-header">
																			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
																			<h4 class="modal-title" id="taskModalEdit1">Alterar Tarefa</h4>
																		</div>
																		<div class="modal-body">																		
																			<form  action="<?= url("/work/modaltask"); ?>" method="post">
																				<div class="form-group">
																					<div class="col-md-12">
																						<label for="task_name">Tarefa:</label>
																						<input value="<?= $task1->task_name;?>" type="text" id="task_name" name="task_name"  class="form-control" placeholder="Nome do Serviço:" required>
																					</div>	
																				</div>	
																				<div class="form-group">
																					<div class="col-md-12">
																						<label for="stage_name">Tarefa:</label>
																						<input type="hidden" name="action" value="update"/>
																						<input type="hidden" name="id" value="<?= $stage1->id;?>"/>
																						<input type="hidden" name="work" value="<?php echo $project->id;?>"/>
																						<select name="stage_name" id="stage_name"   class="form-control">
																							<?php foreach ($stage as $stageList1): ?>
																								<option value="<?php echo $stageList1->id; ?>" <?php if($task1->stage_id==$stageList1->id){ echo "selected"; }?>><?php echo $stageList1->stage_name;?></option> 
																							<?php endforeach;?>
																						</select>
																					</div>	
																				</div>
																				<div class="form-group">
																					<div class="col-md-6">
																						<label for="name">Data de Início da Tarefa:</label>
																						<input value="<?= $task1->date_initial;?>" type="date" id="date_initial" name="date_initial"  class="form-control" placeholder="Data Inicial" required>
																					</div>
																					<div class="col-md-6">
																						<label for="date_final">Data de Entrega da Tarefa:</label>
																						<input value="<?= $task1->date_final;?>" type="date" id="date_final" name="date_final"  class="form-control"  placeholder="Data Final" required>
																					</div>	
																				</div>		
																				<div class="form-group">
																					<div class="col-md-12">
																						<label for="status">Estado da Tarefa:</label>
																						<select name="status" id="status" class="form-control" required>
																							<?php
																								$status = $task1->status;
																								$select = function ($value) use ($status) {
																								return ($status == $value ? "selected" : "");
																								};
																							?>
																							<option <?= $select("active"); ?> value="active">Ativa</option>
																							<option <?= $select("finished"); ?> value="finished">Finalizada</option>
																						</select>
																					</div>	
																				</div>
																				<div class="form-group">
																					<div class="col-md-12">
																						<label for="annotations">Anotações</label>
																						<textarea type="text" class="form-control" id="annotations" name="annotations" placeholder="<?= $task1->annotations;?>"></textarea>
																					</div>	
																				</div>
																																	
																				<div class="form-group p-a-15 ">
																					<button   class="btn btn-primary m-t-15">Alterar</button>
																				</div>																	
																			</form>
																		</div>
																	</div>
																</div>
															</div>	                  
															</tr>
														<?php endif; ?>
													
														<?php endforeach;?>
														<?php endif; ?>	
													<?php endforeach;?>	   
													<?php endif; ?>	   
													</tbody>
												</table>			
											</div>
										</div>	
									</div>
								</div>	
								<!-- Stage -->
								<div id="z2" class="tab-pane fade">	
									<div class="col-md-12">
										<div class="box">
											<header>
												<h4>Etapas</h4>
												<!-- begin box-tools -->
												<div class="box-tools">
													<button type="button" class="btn btn-block btn-primary btn-rect text-uppercase" title="Cadastrar Etapa" data-toggle="modal" data-target="#stageAddModal">
														 Etapa  
													</button>
												</div>
												<!-- END: box-tools -->
											</header>
											<div class="box-body collapse in" id="box2">
												<table class="table table-bordered table-hover m-t-a">
													<thead>
														<th scope="col"style="text-align:center;">Nome da Etapa</th>
														<th scope="col" style="text-align:center;">Data de Início</th>
														<th scope="col" style="text-align:center;">Data de Términio</th>
														<th scope="col" style="text-align:center;">Prazo</th>
														<th scope="col" style="text-align:center;">Status</th>
														<th scope="col" style="text-align:center;">Ações</th>	
													</thead>
													<tbody>
														<?php if (!empty($stage)): ?>	
														<?php foreach ($stage as $stage2):?>
															<tr scope="row">
																<td scope="col" style="text-align:center;"><?php echo $stage2->stage_name;?></td>
																<td scope="col" style="text-align:center;"><?php echo $stage2->date_initial;?></td>
																<td scope="col" style="text-align:center;"><?php echo $stage2->date_final;?></td>
																<td scope="col" style="text-align:center;"><?php echo $stage2->duration;?></td>
																<td scope="col" style="text-align:center;"><?php if($stage2->status == "active"){
																	
																	echo "ATIVO";
																	
																	}else{
																		
																	echo "INATIVO";
												
																	}?></td> 
																
																<td scope="col" style="text-align:center;font-size:12px;">
																	<a title="Visualizar Etapa" class="btn btn-primary btn-xs"><span class="fa fa-file-o fw-fa"></span></a>
																	<a type="button" title="Editar"  class="btn btn-warning btn-xs" 
																		data-toggle="modal" data-target="#stageEditModal2<?php echo $stage2->id;?>"
																	><span class="fa fa-edit fw-fa"></span></a>

																	<a title="Deletar" class="btn-simple btn btn-danger btn-xs" title="" href="#"
																		data-post="<?= url("/work/modalstage/{$stage2->id}"); ?>"
																		data-action="delete"
																		data-confirm="Tem Certeza que Deseja Deletar essa Etapa?"
																		data-id="<?= $stage2->id; ?>"><span class="fa fa-remove fw-fa"></span></a>
																</td>
															</tr>
														<div class="modal fade" id="stageEditModal2<?php echo $stage2->id;?>" tabindex="-1" role="dialog" aria-labelledby="stageModalEdit2">
															<div class="modal-dialog" role="document">
																<div class="modal-content">
																	<div class="modal-header">
																		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
																		<h4 class="modal-title" id="stageModalEdit2">Alterar Etapa</h4>
																	</div>
																	<div class="modal-body">																		
																		<form  action="<?= url("/work/modalstage"); ?>" method="post">
																			
																			<div class="form-group">
																				<div class="col-md-12">
																					<label for="stage_name">Etapa:</label>
																					<input type="hidden" name="action" value="update"/>
																					<input type="hidden" name="id" value="<?= $stage2->id;?>"/>
																					<input type="hidden" name="work" value="<?php echo $project->id;?>"/>
																					<select name="stage_name" id="stage_name"   class="form-control">
																						<?php foreach ($stageCategory as $stageCategoryList2): ?>
																								<option value="<?php echo $stageCategoryList2->name; ?>" <?php if($stage2->stage_name==$stageCategoryList2->name){ echo "selected"; }?>><?php echo $stageCategoryList2->name;?></option> 
																						<?php endforeach;?>
																					</select>
																				</div>	
																			</div>
																			<div class="form-group">
																				<div class="col-md-6">
																					<label for="name">Data de Início da Etapa:</label>
																					<input value="<?= $stage2->date_initial;?>" type="date" id="date_initial" name="date_initial"  class="form-control" placeholder="Data Inicial" required>
																				</div>
																				<div class="col-md-6">
																					<label for="date_final">Data de Entrega da Etapa:</label>
																					<input value="<?= $stage2->date_final;?>" type="date" id="date_final" name="date_final"  class="form-control"  placeholder="Data Final" required>
																				</div>	
																			</div>		
																			<div class="form-group">
																				<div class="col-md-12">
																					<label for="status">Estado da Etapa:</label>
																					<select name="status" id="status" class="form-control" required>
																					<?php
																						$status = $stage2->status;
																						$select = function ($value) use ($status) {
																							return ($status == $value ? "selected" : "");
																						};
																					?>
																						<option <?= $select("active"); ?> value="active">Ativa</option>
																						<option <?= $select("finished"); ?> value="finished">Finalizada</option>
																		
																					</select>
																				</div>	
																			</div>
																			<div class="form-group">
																				<div class="col-md-12">
																					<label for="annotations">Anotações</label>
																					<textarea type="text" class="form-control" id="annotations" name="annotations" placeholder="<?= $stage2->annotations;?>"></textarea>
																				</div>	
																			</div>
																																	
																			<div class="form-group p-a-15 ">
																				<button   class="btn btn-primary m-t-15">Alterar</button>
																			</div>																	
																		</form>
																	</div>
																</div>
															</div>
														</div>	
														<?php endforeach; ?>	
														<?php endif; ?>				
													</tbody>
												</table>			
											</div>
										</div>	
									</div>
								</div>
								<!-- Task -->
								<div id="z3" class="tab-pane fade">	
									<div class="col-md-12">
										<div class="box">
											<header>
												<h4>Tarefas</h4>
												<!-- begin box-tools -->
												<div class="box-tools">
													<button type="button" class="btn btn-block btn-primary btn-rect text-uppercase" title="Cadastrar Tarefa" data-toggle="modal" data-target="#taskAddModal">
														Tarefa  
													</button>
												</div>
												<!-- END: box-tools -->
											</header>
											<div class="box-body collapse in" id="box2">
												<table class="table table-bordered table-hover m-t-a">
													<thead>
														<th scope="col"style="text-align:center;">Terefa</th>
														<th scope="col"style="text-align:center;">Etapa</th>
														<th scope="col" style="text-align:center;">Data de Início</th>
														<th scope="col" style="text-align:center;">Data de Términio</th>
														<th scope="col" style="text-align:center;">Prazo</th>
														<th scope="col" style="text-align:center;">Status</th>
														<th scope="col" style="text-align:center;">Ações</th>	
													</thead>
													<tbody>	
														<?php if (!empty($tasks)): ?>
														<?php foreach ($tasks as $task2):?>
															<?php 	$getStage  = $task2->getStage();?>
															<tr scope="row">task_name
																<td scope="col" style="text-align:center;"><?php echo $task2->task_name;?></td>
																<td scope="col" style="text-align:center;"><?php echo $getStage->stage_name;?></td>
																<td scope="col" style="text-align:center;"><?php echo $task2->date_initial;?></td>
																<td scope="col" style="text-align:center;"><?php echo $task2->date_final;?></td>
																<td scope="col" style="text-align:center;"><?php echo $task2->duration;?></td>
																<td scope="col" style="text-align:center;"><?php if($task2->status == "active"){
																	
																	echo "ATIVO";
																	
																	}else{
																		
																	echo "INATIVO";
												
																	}?></td> 
																
																<td scope="col" style="text-align:center;font-size:12px;">
																	<a title="Visualizar Etapa" class="btn btn-primary btn-xs"><span class="fa fa-file-o fw-fa"></span></a>
																	<a type="button" title="Editar"  class="btn btn-warning btn-xs" 
																		data-toggle="modal" data-target="#taskEditModal<?php echo $task2->id;?>"
																	><span class="fa fa-edit fw-fa"></span></a>

																	<a title="Deletar" class="btn-simple btn btn-danger btn-xs" title="" href="#"
																		data-post="<?= url("/work/modaltask/{$task2->id}"); ?>"
																		data-action="delete"
																		data-confirm="Tem Certeza que Deseja Deletar essa Tarefa?"
																		data-id="<?= $task2->id; ?>"><span class="fa fa-remove fw-fa"></span></a>
																</td>
															</tr>
														<div class="modal fade" id="taskEditModal<?php echo $task2->id;?>" tabindex="-1" role="dialog" aria-labelledby="editModalTask">
															<div class="modal-dialog" role="document">
																<div class="modal-content">
																	<div class="modal-header">
																		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
																		<h4 class="modal-title" id="editModalTask">Editar Tarefa</h4>
																	</div>
																	<div class="modal-body">																		
																		<form  action="<?= url("/work/modaltask"); ?>" method="post">
																			<div class="form-group">
																				<div class="col-md-12">
																					<label for="task_name">Tarefa:</label>
																					<input value="<?= $task2->task_name;?>" type="text" id="task_name" name="task_name"  class="form-control" placeholder="Nome do Serviço:" required>
																				</div>	
																			</div>	
																			<div class="form-group">
																				<div class="col-md-12">
																					<label for="stage_name">Etapa:</label>
																					<input type="hidden" name="action" value="update"/>
																					<input type="hidden" name="id" value="<?= $task2->id;?>"/>
																					<input type="hidden" name="work" value="<?php echo $project->id;?>"/>
																					<select name="stage_id" id="stage_id"   class="form-control">
																						<?php foreach ($stage as $stageList2): ?>
																							<option value="<?php echo $stageList2->id; ?>" <?php if($task2->stage_id==$stageList2->id){ echo "selected"; }?>><?php echo $stageList2->stage_name; ?></option> 
																						<?php endforeach;?>
																					</select>
																				</div>	
																			</div>
																			
											
						
																			<div class="form-group">
																				<div class="col-md-6">
																					<label for="name">Data de Início da Etapa:</label>
																					<input value="<?= $task2->date_initial;?>" type="date" id="date_initial" name="date_initial"  class="form-control" placeholder="Data Inicial" required>
																				</div>
																				<div class="col-md-6">
																					<label for="date_final">Data de Entrega da Etapa:</label>
																					<input value="<?= $task2->date_final;?>" type="date" id="date_final" name="date_final"  class="form-control"  placeholder="Data Final" required>
																				</div>	
																			</div>		
																			<div class="form-group">
																				<div class="col-md-12">
																					<label for="status">Estado da Etapa:</label>
																					<select name="status" id="status" class="form-control" required>
																					<?php
																						$status = $task2->status;
																						$select = function ($value) use ($status) {
																							return ($status == $value ? "selected" : "");
																						};
																					?>
																						<option <?= $select("active"); ?> value="active">Ativa</option>
																						<option <?= $select("finished"); ?> value="finished">Finalizada</option>
																		
																					</select>
																				</div>	
																			</div>
																			<div class="form-group">
																				<div class="col-md-12">
																					<label for="annotations">Anotações</label>
																					<textarea type="text" class="form-control" id="annotations" name="annotations" placeholder="<?= $task2->annotations;?>"></textarea>
																				</div>	
																			</div>
																																	
																			<div class="form-group p-a-15 ">
																				<button   class="btn btn-primary m-t-15">Alterar</button>
																			</div>																	
																		</form>
																	</div>
																</div>
															</div>
														</div>	
														<?php endforeach; ?>
														<?php endif; ?>											
													</tbody>
												</table>			
											</div>
										</div>	
									</div>
								</div>
							</div>
							
							<!-- Modal Stage Add -->
							<div class="modal fade" id="stageAddModal" tabindex="-1" role="dialog" aria-labelledby="addModalStage">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											<h4 class="modal-title" id="addModalStage">Etapa</h4>
										</div>
										<div class="modal-body">																		
											<form  action="<?= url("/work/modalstage");?>" method="post">	
												<div class="form-group">
													<div class="col-md-12">
														<label for="stage_name">Etapa:</label>
														<input type="hidden" name="action" value="create"/>
														<input type="hidden" name="work" value="<?php echo $project->id;?>"/>
														<select name="stage_name" id="stage_name"   class="form-control">
															<?php foreach($stageCategory as $stageCategoryAdd): ?>
																<option value="<?php echo $stageCategoryAdd->name; ?>"> <?php echo $stageCategoryAdd->name; ?></option>   
															<?php endforeach; ?>
														</select>
													</div>	
												</div>
												<div class="form-group">
													<div class="col-md-6">
														<label for="name">Data de Início da Etapa:</label>
														<input  type="date" id="date_initial" name="date_initial"  class="form-control" placeholder="Data Inicial" required>
													</div>
													<div class="col-md-6">
														<label for="date_final">Data de Entrega da Etapa:</label>
														<input  type="date" id="date_final" name="date_final"  class="form-control"  placeholder="Data Final" required>
													</div>	
												</div>		
												<div class="form-group">
													<div class="col-md-12">
														<label for="status">Estado da Etapa:</label>
														<select name="status" id="status" class="form-control" required>
															<option value="active">Ativa</option>
															<option  value="finished">Finalizada</option>
														</select>
													</div>	
												</div>
												<div class="form-group">
													<div class="col-md-12">
														<label for="annotations">Anotações</label>
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
							
						</div>	
					</div>
                </div>
			</div>
		</div>
	</div>
    <!-- begin .main-footer -->
    <footer class="main-footer bg-white p-a-5">
		main footer
    </footer>
    <!-- END: .main-footer -->
 </div>
		      

 


