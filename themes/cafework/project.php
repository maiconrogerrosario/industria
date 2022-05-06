<?php $v->layout("_theme"); ?>

<div class="app-main">
    <!-- begin .main-heading -->
    <header class="main-heading shadow-2dp">
		<!-- begin dashhead -->
		<!-- <div class="dashhead bg-white">
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
		</div> -->
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
							<h4> Detalhes da Obra ou Serviços</h4>
							<!-- begin box-tools -->
							<!-- <div class="box-tools">
							<a class="fa fa-fw fa-minus" href="#" data-box="collapse"></a>
							<a class="fa fa-fw fa-times" href="#" data-box="close"></a>
							</div>-->
							<!-- END: box-tools -->
						</header>
						<div class="box-body">
						
								
							<table class="table table-striped" align="left"  width="100%">		
								<tbody>
									
									
								
									<tr>
										<tr>
											<td><strong>Nome da Obra ou Serviço</strong></td><td align="left"><?php echo $project->name;?>
										</tr>
										<tr>
											<td><strong>Data Inicial:</strong></td><td><?= ($project->date_initial ? date_fmt($project->date_initial, "d/m/Y") : null); ?>
										</tr>
										<tr>
											<td><strong>Data Final:</strong></td><td><?= ($project->date_final ? date_fmt($project->date_final, "d/m/Y") : null); ?>
										</tr>
										
										<tr>
											<td><strong>Valor Total do Projeto:</strong></td><td><?= "R$ " . str_price($project->projectcost );?>
										</tr>
										
										<?php if (!empty($walletsproject)): ?>

										
										
											<?php $valor = ($project->projectcost - $atualizar->balanceWallet($walletsproject)->expense  ); ?>
										
										
										<tr>
											<td><strong>Caixa do Projeto:</strong></td><td><span class="atualizarvalor"><?="R$ " . str_price($valor ?? 0);?></span>
										</tr>
										<tr>
											<td><strong>Saldo:</strong></td><td>
											
											
											<span class="atualizarincomeamount">
											<?= "R$ " . str_price(($atualizar->balanceWallet($walletsproject)->wallet ?? 0)); ?></span>
	
										</tr>
										<tr>
											<td><strong>Receitas:</strong></td><td>
											
											
											<span class="atualizarincome">
											<?= "R$ " . str_price(($atualizar->balanceWallet($walletsproject)->income ?? 0)); ?></span>
											
										</tr>
										<tr>
											<td><strong>Despesas:</strong></td><td>

											<span class="atualizarexpense"><?= "R$ " . str_price(($atualizar->balanceWallet($walletsproject)->expense ?? 0)); ?></span>
										
										</tr>
										<tr>
											<td><strong>Status da Obra ou Serviço:</strong></td><td>
												<?php 
													if($project->status == "active"){
														echo "ATIVO";
													
													}else{
														echo "INATIVO";
													}
												?>                   
										</tr>
										<tr>
											<td><strong>Importar Faturas</strong></td><td>
												<button class="btn btn-primary" title="Importar Planilhas" data-toggle="modal" data-target="#importInvoiceModal">
														Planilha
												</button>              
										</tr>
										<?php else: ?>
										<tr>
											<tr>
												<td><strong>Status da Obra ou Serviço:</strong></td><td>		
												<?php 
													if($project->status == "active"){
														echo "ATIVO";
														
													}else{
														
														echo "INATIVO";
												
													}
												?>                   
											</tr>
											<td>
												<form action="<?= url("/work/wallets/new"); ?>" method="post" autocomplete="off">
													<input type="hidden" name="wallet_name" value="<?php echo $project->name;?>"/>
													<input type="hidden" name="project_id" value="<?php echo $project->id;?>"/>
													<button class="btn btn-primary">
														<span class="fa fa-i fa-check"></span> Abrir Carteira
													</button>
												</form>
											</td><td>		
										</tr>			
										<?php endif; ?>
									</tr>	
								</tbody>								
							</table>	
						</div>
					</div>	
				</div>
				<div class="col-sm-12">
					<div class="box">
						<div class="box-body">
							<div class="form-group">
								<div class="highcharts-figure">
									<div id="grafico"></div>
								</div>	
							</div>
						</div>	
					</div>
				</div>
				
				<div class="col-sm-12">
					<div class="box">
							<header>
								
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
								<li class="">
									<a href="#z4" data-toggle="tab" aria-expanded="false">Arquivos</a>
								</li>
								
								<li class="">
									<a href="#z5" data-toggle="tab" aria-expanded="false">Receber</a>
								</li>
								
								<li class="">
									<a href="#z6" data-toggle="tab" aria-expanded="false">Pagar</a>
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
														<form  action="<?= url("/work/cronograma/{$project->id}"); ?>" method="post">
															<a title="Imprimir Cronograma" style="color: #fff;" href="<?= url("/work/cronograma/{$project->id}"); ?>" class="btn btn-block btn-primary btn-rect text-uppercase">Imprimir</a>		
														</form>
													</div>
													<!-- begin box-tools -->
													<div class="box-tools  p-a-5">
														<form  action="<?= url("/work/cronograma/{$project->id}"); ?>" method="post">
															<a title="Imprimir Cronograma" style="color: #fff;" href="<?= url("/work/cronograma/{$project->id}"); ?>" class="btn btn-block btn-primary btn-rect text-uppercase">Importar Cronograma</a>		
														</form>
													</div>
													<!-- begin box-tools -->
													<div class="box-tools p-a-5">
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
														<th scope="col" style="text-align:center;">Descrição</th>
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
																<th scope="col" style="text-align:center;">Etapa</th>
																<th scope="col"style="text-align:center;"><?php echo  $stage1->stage_name;?></th>
																<th scope="col" style="text-align:center;"><?php echo ($stage1->date_initial ? date_fmt($stage1->date_initial, "d/m/Y") : null); ?></th>
																<th scope="col" style="text-align:center;"><?php echo ($stage1->date_final ? date_fmt($stage1->date_final, "d/m/Y") : null); ?></th>
																<th scope="col" style="text-align:center;"><?php echo $stage1->duration;?></th>
																<th scope="col" style="text-align:center;">
																	
																	<?php if($stage1->status == "active"){
																			echo "ATIVO";
																
																		} else {
																			echo "INATIVO";
												
																		}
				
																	?>
																	
																</th>
																<th scope="col" style="text-align:center;font-size:12px;">
																	<a title="Visualizar Etapa" class="btn btn-primary btn-xs"><span class="fa fa-file-o fw-fa"></span></a>
																	<a type="button" title="Editar"  class="btn btn-warning btn-xs" 
																		data-toggle="modal" data-target="#stageEditModal1<?php echo $stage1->id;?>">
																		<span class="fa fa-edit fw-fa"></span>
																	</a>
																	<a title="Deletar" class="btn-simple btn btn-danger btn-xs" title="" href="#"
																		data-post="<?= url("/work/modalstage/{$stage1->id}"); ?>"
																		data-action="delete"
																		data-confirm="Tem Certeza que Deseja Deletar essa Etapa?"
																		data-id="<?= $stage1->id; ?>"><span class="fa fa-remove fw-fa"></span>
																	</a>									
																	<span class="j_stage_status">
																	
																	</span>	
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
																						<input value="<?= $stage1->stage_name;?>" type="text" id="stage_name" name="stage_name"  class="form-control"  placeholder="Etapa" required>

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
																	<?php if ($stage1->stage_name ==  $task1->stage_name): ?>
																		
																
																		<tr scope="row">
																			<td scope="col" style="text-align:center;">Tarefa</td>
																			<td scope="col" style="text-align:center;"><?php echo $task1->task_name;?></td>
																			<td scope="col" style="text-align:center;"><?php echo ($task1->date_initial ? date_fmt($task1->date_initial, "d/m/Y") : null);?></td>
																			<td scope="col" style="text-align:center;"><?php echo ($task1->date_final ? date_fmt($task1->date_final, "d/m/Y") : null); ?></td>
																			<td scope="col" style="text-align:center;"><?php echo $task1->duration;?></td>
																			<td scope="col" style="text-align:center;">
																					<span class="taskstatus" >
																	
																						<?php if($task1->status == "active"){
																	
																								echo "ATIVO";
																	
																							}else{
																		
																								echo "INATIVO";
												
																							}
																			
																						?>
																						
																					</span>
																					
																			</td>
																			<td scope="col" style="text-align:center;font-size:12px;">
																				<a title="Visualizar Etapa" class="btn btn-primary btn-xs"><span class="fa fa-file-o fw-fa"></span></a>
																				<a type="button" title="Editar"  class="btn btn-warning btn-xs" 
																					data-toggle="modal" data-target="#taskEditModal1<?php echo $task1->id;?>"
																				><span class="fa fa-edit fw-fa"></span></a>

																				<a title="Deletar" class="btn-simple btn btn-danger btn-xs" title="" href="#"
																					data-post="<?= url("/work/deletetask/{$task1->id}"); ?>"
																					data-action="delete"
																					data-confirm="Tem Certeza que Deseja Deletar essa Tarefa?"
																					data-task_id="<?=$task1->id;?>"><span class="fa fa-remove fw-fa"></span></a>
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
																										<label for="stage_name">Etapa:</label>
																										<input type="hidden" name="action" value="update"/>
																										<input type="hidden" name="id" value="<?= $task1->id;?>"/>
																										<input type="hidden" name="work" value="<?php echo $project->id;?>"/>
																										<select name="stage_name" id="stage_name"   class="form-control">
																											<?php foreach ($stage as $stageList1): ?>
																												<option value="<?php echo $stageList1->stage_name; ?>" <?php if($task1->stage_name==$stageList1->stage_name){ echo "selected"; }?>><?php echo $stageList1->stage_name; ?></option> 
																											<?php endforeach;?>
																										</select>
																									</div>	
																								</div>
																								<div class="form-group">
																									<div class="col-md-6">
																										<label for="name">Data de Início da Etapa:</label>
																										<input value="<?= $task1->date_initial;?>" type="date" id="date_initial" name="date_initial"  class="form-control" placeholder="Data Inicial" required>
																									</div>
																									<div class="col-md-6">
																										<label for="date_final">Data de Entrega da Etapa:</label>
																										<input value="<?= $task1->date_final;?>" type="date" id="date_final" name="date_final"  class="form-control"  placeholder="Data Final" required>
																									</div>	
																								</div>		
																								<div class="form-group">
																									<div class="col-md-12">
																										<label for="status">Estado da Etapa:</label>
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
																
															
															<?php 
																
																$active = "active";
																$finished ="finished";
																
															foreach ($stage as $stage2):?>
																
																<tr scope="row">
																	<td scope="col" style="text-align:center;"><?php echo $stage2->stage_name;?></td>
																	<td scope="col" style="text-align:center;"><?php echo ($stage2->date_initial ? date_fmt($stage2->date_initial, "d/m/Y") : null); ?></td>
																	<td scope="col" style="text-align:center;"><?php echo ($stage2->date_final ? date_fmt($stage2->date_final, "d/m/Y") : null); ?></td>
																	<td scope="col" style="text-align:center;"><?php echo $stage2->duration;?></td>
																	<td scope="col" style="text-align:center;">
																		<span class="j_stage_status" ></span>

																	        <?php if ($stage2->status == 'finished'): ?>
																				<span class="fa fa-i fa-thumbs-o-down "
																					data-toggleclass="active fa fa-i fa-thumbs-o-down fa fa-i fa-thumbs-o-up"
																					data-stagestatus="<?= url("/work/stagestatus"); ?>"
																					data-sstatus="finished"
																					data-stages="<?= $stage2->id; ?>">
																				</span>
																			<?php else: ?>
																				<span class="fa fa-i fa-thumbs-o-up"
																					data-toggleclass="active fa fa-i fa-thumbs-o-down fa fa-i fa-thumbs-o-up"
																					data-stagestatus="<?= url("/work/stagestatus"); ?>"
																					data-sstatus="active"
																					data-stages="<?= $stage2->id; ?>">
																				</span>
																				
																				

																			<?php endif; ?>		

																	</td> 
																 
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
																							<input name="stage_name" id="stage_name" value="<?php echo $stage2->stage_name ?>"   class="form-control">
																							
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
																									$status2 = $stage2->status;
																									$select2 = function ($value2) use ($status2) {
																										return ($status2 == $value2 ? "selected" : "");
																									};
																								?>
																								<option <?= $select2("active"); ?> value="active">Ativa</option>
																								<option <?= $select2("finished"); ?> value="finished">Finalizada</option>
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
								<!-- Task Start-->
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
																
																<tr scope="row">
																	<td scope="col" style="text-align:center;"><?php echo $task2->task_name;?></td>
																	<td scope="col" style="text-align:center;"><?php echo $task2->stage_name;?></td>
																	<td scope="col" style="text-align:center;"><?php echo ($task2->date_initial ? date_fmt($task2->date_initial, "d/m/Y") : null); ?></td>
																	<td scope="col" style="text-align:center;"><?php echo ($task2->date_final ? date_fmt($task2->date_final, "d/m/Y") : null); ?></td>
																	<td scope="col" style="text-align:center;"><?php echo $task2->duration;?></td>
																	<td  scope="col" style="text-align:center;">
																	
																		
																			<?php if ($task2->status == 'finished'): ?>
																				<span class="fa fa-i fa-thumbs-o-down "
																					data-toggleclass="active fa fa-i fa-thumbs-o-down fa fa-i fa-thumbs-o-up"
																					data-taskstatus="<?= url("/work/taskstatus"); ?>"
																					data-status="finished"
																					data-task="<?= $task2->id; ?>">
																				</span>
																			<?php else: ?>
																				<span class="fa fa-i fa-thumbs-o-up"
																					data-toggleclass="active fa fa-i fa-thumbs-o-down fa fa-i fa-thumbs-o-up"
																					data-taskstatus="<?= url("/work/taskstatus"); ?>"
																					data-status="active"
																					data-task="<?= $task2->id; ?>">
																				</span>
																			<?php endif; ?>				
																			
																	

																	
																	</td> 
																	<td scope="col" style="text-align:center;font-size:12px;">
																		<a title="Visualizar Etapa" class="btn btn-primary btn-xs"><span class="fa fa-file-o fw-fa"></span></a>
																		<a type="button" title="Editar"  class="btn btn-warning btn-xs" 
																			data-toggle="modal" data-target="#taskEditModal<?php echo $task2->id;?>"
																			><span class="fa fa-edit fw-fa"></span></a>

																		<a title="Deletar" class="btn-simple btn btn-danger btn-xs" title="" href="#"
																			data-post="<?= url("/work/deletetask/{$task2->id}"); ?>"
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
																							<select name="stage_name" id="stage_name"   class="form-control">
																								<?php foreach ($stage as $stageList2): ?>
																									<option value="<?php echo $stageList2->stage_name; ?>" <?php if($task2->stage_name==$stageList2->stage_name){ echo "selected"; }?>><?php echo $stageList2->stage_name; ?></option> 
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
								<!-- Task End-->
								
								<!-- Files Start-->
								<div id="z4" class="tab-pane fade">	
									<div class="col-md-12">
										<div class="box">
											<header>
												<h4>Arquivos</h4>
												<!-- begin box-tools -->
												<div class="box-tools">
													<button type="button" class="btn btn-block btn-primary btn-rect text-uppercase" title="Cadastrar Tarefa" data-toggle="modal" data-target="#fileAddModal">
														Importar Arquivos
													</button>
												</div>
												<!-- END: box-tools -->
											</header>
											<div class="box-body collapse in" id="box2">
												<table class="table table-bordered table-hover m-t-a">
													<thead>
														<th scope="col"style="text-align:center;">TÍTULO</th>
														<th scope="col"style="text-align:center;">SUBTÍTULO</th>
														<th scope="col"style="text-align:center;">DESCRIÇÃO</th>
														<th scope="col"style="text-align:center;">DATA DA CRIAÇÃO</th>
														<th scope="col"style="text-align:center;">DATA DA MODIFICAÇÃO</th>
														<th scope="col"style="text-align:center;">STATUS</th>
														<th scope="col"style="text-align:center;">AÇÕES</th>
													</thead>
													<tbody>	
														<?php if (!empty($fileProjects)): ?>
															<?php foreach ($fileProjects as $fileProject):?>
																<tr scope="row">
																	<td scope="col" style="text-align:center;"><?php echo $fileProject->title;?></td>
																	<td scope="col" style="text-align:center;"><?php echo $fileProject->subtitle;?></td>
																	<td scope="col" style="text-align:center;"><?php echo $fileProject->description?></td>
																	<td scope="col" style="text-align:center;"><?php echo ($fileProject->created_at ? date_fmt($fileProject->created_at, "d/m/Y") : null); ?></td>
																	<td scope="col" style="text-align:center;"><?php echo ($fileProject->updated_at ? date_fmt($fileProject->updated_at, "d/m/Y") : null); ?></td>
																	<td scope="col" style="text-align:center;">
																		<span class="j_task_status" ><?php if($fileProject->status == "active"){
																	
																			echo "ATIVO";
																	
																			}else{
																		
																				echo "INATIVO";
												
																			}
																			
																		?></span>
																		
																		
																		
																		
																		
																	</td> 
																	<td scope="col" style="text-align:center;font-size:12px;">
																		<a type="button" href="<?= url("/storage/{$fileProject->cover}"); ?>" title="Abaixar Documento" class="btn btn-primary btn-xs"><span class="fa fa-download fw-fa"></span></a>
																	
																	

																		<a title="Deletar" class="btn-simple btn btn-danger btn-xs" title="" href="#"
																			data-post="<?= url("/work/modalprojectfile/{$fileProject->id}"); ?>"
																			data-action="delete"
																			data-confirm="Tem Certeza que Deseja Deletar essa Tarefa?"
																			data-id="<?= $fileProject->id; ?>"><span class="fa fa-remove fw-fa"></span></a>
																	</td>
																</tr>
																<!-- Modal File Start Edit -->
																<div class="modal fade" id="fileEdit<?php echo $fileProject->id;?>" tabindex="-1" role="dialog" aria-labelledby="editfile">
																	<div class="modal-dialog" role="document">
																		<div class="modal-content">
																			<div class="modal-header">
																				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
																				<h4 class="modal-title" id="editfile">Tarefa</h4>
																			</div>
																			<div class="modal-body">																		
																				<form  action="<?= url("/work/modalprojectfile");?>" method="post">
																					<div class="form-group">
																						<div class="col-md-12">
																							<label for="title">Título do Documento</label>
																							<input type="hidden" name="action" value="update"/>
																							<input type="hidden" name="id" value="<?= $fileProject->id;?>"/>
																							<input type="hidden" name="work" value="<?php echo $project->id;?>"/>
																							<input type="text" value="<?php echo $fileProject->title;?>" class="form-control" id="title" name="title" placeholder="Título do Documento" required/>
																						</div>
																					</div>		
																					<div class="form-group">
																						<div class="col-md-12">
																							<label for="subtitle">Subtítulo do Documento</label>
																							<input type="text" value="<?php echo $fileProject->subtitle;?>" class="form-control" id="subtitle" name="subtitle" placeholder="Subtítulo do Documento" />
																						</div>	
																					</div>
																					<div class="form-group">
																						<div class="col-md-12">
																							<label for="status" >Status</label>
																								<select name="status" id="status" class="form-control" required>
																									<?php
																										$statusfile = $fileProject->status;
																								
																										$selectfile = function ($valuefile) use ($statusfile) {
																									
																											return ($statusfile == $valuefile ? "selected" : "");
																									
																										};
																									?>
																									<option <?= $selectfile("active"); ?> value="active">Documento Ativo</option>
																									<option <?= $selectfile("finished"); ?> value="finished">Documento Inativo</option>
																								</select>
																							
		
																						</div>	
																					</div>		
																					<div class="form-group">
																						<div class="col-md-12">
																							<label for="description">Descrição do Arquivo</label>
																							<textarea class="form-control" name="description" placeholder="Descrição"><?php echo $fileProject->description;?></textarea>
																						</div>
																					</div>
																					<div class="form-group">
																						<div class="col-md-12">
																							<label for="cover">Inserir Documento</label>
																							<input type="file" <?php echo $fileProject->cover;?> class="form-control" name="cover" placeholder="Inserir Documento"/>
																						</div>	
																					</div>

																					<div class="form-group p-a-15 ">
																						<button  class="btn btn-primary m-t-15">Alterar</button>
																					</div>								
																				</form>	
																			</div>
																		</div>
																	</div>
																</div>
																<!-- Modal File End Edit -->	
															<?php endforeach; ?>
														<?php endif; ?>											
													</tbody>
												</table>			
											</div>
										</div>	
									</div>
								</div>
								<!-- Files End-->
								<!-- Pagar Start-->
								<div id="z5" class="tab-pane fade">
									<div class="col-xs-12">
										<div class="box">
											<div class="box-body">
												<div class="cafecontrol_launch_header">
													<?php $type = "income" ?>
													<div class="cafecontrol_launch_btn <?= $type; ?> radius transition "
														data-modalopen=".cafecontrol_modal_project_<?= $type; ?>"><span class="fa fa-i fa-plus-circle"></span>Lançar
														<?= ($type == "income" ? "Receita" : "Despesa"); ?>
													</div>
												</div>	
											</div>
											<div class="box-body">
												<div class="cafecontrol_launch_box">
												
												<?php if (!$walletsproject): 	?> 
															<div class="message info">
															<span class="fa fa-i fa-exclamation-circle"></span>
																Ainda não foi criada uma 
															carteira para esse projeto
															</div>
													
												
													
												<?php else: ?>
												
												<?php 
												     $incomes = $income->filterProject($user, "income", ($data ?? null), $walletsproject->id);

												?>
												
													<?php if (!$incomes): ?>
															<div class="message info"><span class="fa fa-i fa-exclamation-circle"></span>Ainda não existem contas
																a <?= ($type == "income" ? "receber" : "pagar"); ?>
																. Comece lançando suas <?= ($type == "income" ? "receitas" : "despesas"); ?>.
															</div>
													
													<?php else: ?>
														<table class="table table-hover">
															<thead>
																<th scope="col" style="text-align:center;font-size:12px;">DESCRIÇÃO</th>
																<th scope="col" style="text-align:center;font-size:12px;">VENCIMENTO</th>
																<th scope="col" style="text-align:center;font-size:12px;">CATEGORIA</th>
																<th scope="col" style="text-align:center;font-size:12px;">PARCELA</th>
																<th scope="col" style="text-align:center;font-size:12px;">VALOR</th>
															</thead>
															<tbody>	
																<?php
																	$unpaidincome = 0;
																	$paidincome = 0;
																	foreach ($incomes as $incomes):
																	
																	
																?>
																	<tr scope="row">
																		<td  scope="col" style="text-align:center;font-size:15px;" class="desc cafecontrol_invoice_link transition">
																			<span class="cafecontrol_invoice_link">
																				<a title="<?= $incomes->description; ?>"
																					href="<?= url("/work/fatura/{$incomes->id}"); ?>"><?= str_limit_words($incomes->description,
																					6, "&nbsp;<span><i class='fa fa-i fa-exclamation-circle fa fa-i fa-notext'></i></span>") ?>
																				</a>
																			</span>
																		</td>
																		<td scope="col" style="text-align:center;font-size:15px;" class="date"><?= date_fmt($incomes->due_at, "d/m/Y"); ?></td>
																		<td scope="col" style="text-align:center;font-size:15px;" class="category"><?= $incomes->category()->name; ?></td>
																		<td scope="col" style="text-align:center;font-size:15px;" class="enrollment">
																			<?php if ($incomes->repeat_when == "fixed"): ?>
																				<span class="cafecontrol_invoice_link">
																					<a href="<?= url("/work/fatura/{$incomes->invoice_of}"); ?>" 
																					title="Controlar Conta Fixa"><i  class="fa fa-i fa-exchange"></i>Fixa</a>
																				</span>
																			<?php elseif ($incomes->repeat_when == 'enrollment'): ?>
																				<span class="cafecontrol_invoice_link">
																					<a href="<?= url("/work/fatura/{$incomes->invoice_of}"); ?>"
																						title="Controlar Parcelamento"><?= str_pad($incomes->enrollment_of, 2, 0,
																						0); ?> de <?= str_pad($incomes->enrollments, 2, 0, 0); ?></a>
																				</span>
																			<?php else: ?>
																				<span><i class="fa fa-i fa-calendar-check-o"></i>Única</span>
																			<?php endif; ?>
																		</td>
																		<td scope="col" style="text-align:center;font-size:15px;" class="price">
														
																			<span>R$ <?= str_price($incomes->value); ?></span>
																			<?php if ($incomes->status == 'unpaid'): $unpaidincome += $incomes->value; ?>
																				<span class="check <?= $type; ?> fa fa-i fa-thumbs-o-down transition"
																					data-toggleclass="active fa fa-i fa-thumbs-o-down fa fa-i fa-thumbs-o-up"
																					data-onpaidincome="<?= url("/work/onpaidincome"); ?>"
																					data-date="<?= (date("m/Y")); ?>"
																					data-invoice="<?= $incomes->id; ?>">
																				</span>
																			<?php else: $paidincome += $incomes->value; ?>
																				<span class="check <?= $type; ?> fa fa-i fa-thumbs-o-up transition"
																					data-toggleclass="active fa fa-i fa-thumbs-o-down fa fa-i fa-thumbs-o-up"
																					data-onpaidincome="<?= url("/work/onpaidincome"); ?>"
																					data-date="<?= (date("m/Y")); ?>"
																					data-invoice="<?= $incomes->id; ?>">
																				</span>
																			<?php endif; ?>	
																		</td>
																	</tr>
																	<?php endforeach; ?>
																
																
															</tbody>
														</table>
														<div class="cafecontrol_launch_item footer">
															<p class="j_total_unpaid_income"><i class="fa fa-i fa-thumbs-o-down"></i> R$ <?= str_price($unpaidincome); ?></p>
															<p class="j_total_paid_income"><i class="fa fa-i fa-thumbs-o-up"></i>  R$ <?= str_price($paidincome); ?></p> 
								
														</div>
													<?php endif; ?>	
												
												
												<?php endif; ?>	
												
												
												</div>	
											</div>
										</div>		
									</div>	
								</div>
								<!-- Pagar End-->
								<div id="z6" class="tab-pane fade">
									<div class="col-xs-12">
										<div class="box">
											<div class="box-body">
												<div class="cafecontrol_launch_header">
													<?php $type = "expense" ?>
													<div class="cafecontrol_launch_btn <?= $type; ?> radius transition "
														data-modalopen=".cafecontrol_modal_project_<?= $type; ?>"><span class="fa fa-i fa-plus-circle"></span>Lançar
														<?= ($type == "income" ? "Receita" : "Despesa"); ?>
													</div>
												</div>	
											</div>
											
											
											<div class="box-body">
												<div class="cafecontrol_launch_box">
														
																	
													
													
													<?php	$expenses = $expense->filterProject($user, "expense", ($data ?? null), $walletsproject->id); ?>
															
													<?php if (!$expenses): ?>
															<div class="message info"><span class="fa fa-i fa-exclamation-circle"></span>Ainda não existem contas
																a <?= ($type == "income" ? "receber" : "pagar"); ?>
																. Comece lançando suas <?= ($type == "income" ? "receitas" : "despesas"); ?>.
															</div>
													
													<?php else: ?>
														<table class="table table-hover">
															<thead>	
																<th scope="col" style="text-align:center;font-size:12px;">DESCRIÇÃO</th>
																<th scope="col" style="text-align:center;font-size:12px;">VENCIMENTO</th>
																<th scope="col" style="text-align:center;font-size:12px;">CATEGORIA</th>
																<th scope="col" style="text-align:center;font-size:12px;">PARCELA</th>
																<th scope="col" style="text-align:center;font-size:12px;">VALOR</th>
															</thead>
															<tbody>	
															
																<?php
																	$unpaidexpense = 0;
																	$paidexpense= 0;
																	$expenses = $expense->filterProject($user, "expense", ($data ?? null), $walletsproject->id);

																	
																	foreach ($expenses as $expenses):
																?>
																
																	<tr scope="row">
																		<td  scope="col" style="text-align:center;font-size:15px;" class="desc cafecontrol_invoice_link transition">
																			<span class="cafecontrol_invoice_link">
																				<a title="<?= $expenses->description; ?>"
																					href="<?= url("/work/fatura/{$expenses->id}"); ?>"><?= str_limit_words($expenses->description,
																					6, "&nbsp;<span><i class='fa fa-i fa-exclamation-circle fa fa-i fa-notext'></i></span>") ?>
																				</a>
																			</span>
																		</td>
																		<td scope="col" style="text-align:center;font-size:15px;" class="date"><?= date_fmt($expenses->due_at, "d/m/Y");  ?></td>
																		<td scope="col" style="text-align:center;font-size:15px;" class="category"><?= $expenses->category()->name; ?></td>
																		<td scope="col" style="text-align:center;font-size:15px;" class="enrollment">
																			<?php if ($expenses->repeat_when == "fixed"): ?>
																				<span class="cafecontrol_invoice_link">
																					<a href="<?= url("/work/fatura/{$expenses->invoice_of}"); ?>" 
																					title="Controlar Conta Fixa"><i  class="fa fa-i fa-exchange"></i>Fixa</a>
																				</span>
																			<?php elseif ($expenses->repeat_when == 'enrollment'): ?>
																				<span class="cafecontrol_invoice_link">
																					<a href="<?= url("/work/fatura/{$expenses->invoice_of}"); ?>"
																						title="Controlar Parcelamento"><?= str_pad($expenses->enrollment_of, 2, 0,
																						0); ?> de <?= str_pad($expenses->enrollments, 2, 0, 0); ?></a>
																				</span>
																			<?php else: ?>
																				<span><i class="fa fa-i fa-calendar-check-o"></i>Única</span>
																			<?php endif; ?>
																		</td>
																		<td scope="col" style="text-align:center;font-size:15px;" class="price">
														
																			<span>R$ <?= str_price($expenses->value); ?></span>
																			<?php if ($expenses->status == 'unpaid'): $unpaidexpense += $expenses->value; ?>
																				<span class="check <?= $type; ?> fa fa-i fa-thumbs-o-down transition"
																					data-toggleclass="active fa fa-i fa-thumbs-o-down fa fa-i fa-thumbs-o-up"
																					data-onpaidexpense="<?= url("/work/onpaidexpense"); ?>"
																					data-date="<?= (date("m/Y")); ?>"
								
																					data-invoice="<?= $expenses->id; ?>">
																				</span>
																			<?php else: $paidexpense += $expenses->value; ?>
																				<span class="check <?= $type; ?> fa fa-i fa-thumbs-o-up transition"
																					data-toggleclass="active fa fa-i fa-thumbs-o-down fa fa-i fa-thumbs-o-up"
																					data-onpaidexpense="<?= url("/work/onpaidexpense"); ?>"
																					data-date="<?= (date("m/Y")); ?>"
																					data-invoice="<?= $expenses->id; ?>">
																				</span>
																			<?php endif; ?>	
																		</td>
																	</tr>
																<?php endforeach; ?>
															</tbody>
														</table>
													<div class="cafecontrol_launch_item footer">
															<p class="j_total_unpaid_expense"><i class="fa fa-i fa-thumbs-o-down"></i> R$ <?= str_price($unpaidexpense); ?></p>
															<p class="j_total_paid_expense"><i class="fa fa-i fa-thumbs-o-up"></i>  R$ <?= str_price($paidexpense); ?></p> 
							
													</div>
													
													
													<?php endif; ?>		
														
													
													
																	

																	
															
												
												
													
												</div>	
											</div>
										</div>		
									</div>	
								</div>	
								<!-- Receber End-->
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
														<input  type="text" id="stage_name" name="stage_name"  class="form-control" placeholder="Nome da Etapa" required>
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
							<!-- Modal Stage End Add -->
							
							<!-- Modal Task Start Add -->
							<div class="modal fade" id="taskAddModal" tabindex="-1" role="dialog" aria-labelledby="addModalTask">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											<h4 class="modal-title" id="addModalTask">Tarefa</h4>
										<div class="modal-body">																		
										</div>
											<form  action="<?= url("/work/modaltask");?>" method="post">
												<div class="form-group">
													<div class="col-md-12">
														<label for="task_name">Tarefa:</label>
														<input type="text" id="task_name" name="task_name"  class="form-control" placeholder="Nome da Tarefa:" required>
													</div>	
												</div>	
												<div class="form-group">
													<div class="col-md-12">
														<label for="stage_name">Etapa:</label>
														<input type="hidden" name="action" value="create"/>
														<input type="hidden" name="work" value="<?php echo $project->id;?>"/>
														<select name="stage_name" id="stage_name"   class="form-control">
															<?php foreach($stage as $stageListAdd): ?>
																<option value="<?=$stageListAdd->stage_name;?>"><?= $stageListAdd->stage_name;?></option>
															<?php endforeach; ?>
														</select>
													</div>	
												</div>
												
												<div class="form-group">
													<div class="col-md-6">
														<label for="name">Data de Início da Tarefa:</label>
														<input  type="date" id="date_initial" name="date_initial"  class="form-control" placeholder="Data Inicial" required>
													</div>
													<div class="col-md-6">
														<label for="date_final">Data de Entrega da Tarefa:</label>
														<input  type="date" id="date_final" name="date_final"  class="form-control"  placeholder="Data Final" required>
													</div>	
												</div>		
												<div class="form-group">
													<div class="col-md-12">
														<label for="status">Estado da Tarefa:</label>
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
							<!-- Modal Task End Add -->	
							
							<!-- Modal File Start Add -->
							<div class="modal fade" id="fileAddModal" tabindex="-1" role="dialog" aria-labelledby="addModalTask">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											<h4 class="modal-title" id="addModalFile">Arquivos</h4>
										</div>
										<div class="modal-body">																		
											<form class="form-horizontal"  action="<?= url("/work/modalprojectfile");?>" method="post">
												<div class="form-group">
													<div class="col-md-12">
														<label for="title">Título do Documento</label>
														<input type="hidden" name="action" value="create"/>
														<input type="hidden" name="project" value="<?php echo $project->id;?>"/>
														<input type="text" class="form-control" id="title" name="title" placeholder="Título do Documento" required/>
													</div>
												</div>		
												<div class="form-group ">
													<div class="col-md-12">
														<label for="subtitle">Subtítulo do Documento</label>
														<input type="text" class="form-control" id="subtitle" name="subtitle" placeholder="Subtítulo do Documento" />
													</div>	
												</div>
												<div class="form-group">
													<div class="col-md-12">
														<label for="status" >Status</label>
															<select name="status" id="status"   class="form-control" required>	
																<option value="active">Documento Ativo</option>
																<option value="inactive">Documento Inativo</option>
															</select>
													</div>	
												</div>		
												<div class="form-group">
													<div class="col-md-12">
														<label for="description">Descrição do Arquivo</label>
														<textarea class="form-control" name="description" placeholder="Descrição"></textarea>
													</div>
												</div>
												<div class="form-group">
													<div class="col-md-12">
														<label for="cover">Inserir Documento</label>
														<input type="file" class="form-control" name="cover" placeholder="Inserir Documento" required/>
													</div>	
												</div>
												
												<div class="form-group p-a-15">
													<button  class="btn btn-primary m-t-15">Cadastrar</button>
												</div>								
											</form>	
										</div>
									</div>
								</div>
							</div>
							<!-- Modal File End Add -->	

							<!-- Modal Import Invoice Start Add -->
							<div class="modal fade" id="importInvoiceModal" tabindex="-1" role="dialog" aria-labelledby="modalImportInvoice">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											<h4 class="modal-title" id="modalImportInvoice">Importar Planilha de Receita e Despesas</h4>
										</div>
										<div class="modal-body">																		
											<form class="form-horizontal"  action="<?= url("/work/modalimportinvoices");?>" enctype="multipart/form-data">		
												<div class="form-group">
													<div class="col-md-12">
														<label for="description">Carteira do Projeto</label>
														<input class="form-control" name="wallet" placeholder="Carteira do Projeto" value="<?= $walletsproject->wallet; ?>" readonly/>
													</div>
												</div>
												<div class="form-group">
													<div class="col-md-12">
														<label for="cover">Inserir Documento</label>
														<input type="file" class="form-control" name="cover" placeholder="Inserir Documento" required/>
													</div>	
												</div>
												
												<div class="form-group p-a-15">
													<button  class="btn btn-primary m-t-15">Cadastrar</button>
												</div>								
											</form>	
										</div>
									</div>
								</div>
							</div>
							<!-- Modal Import Invoice Start Add -->
						</div>	
					</div>
                </div>
			</div>
		</div>
	</div>
    <!-- begin .main-footer -->
    <!--<footer class="main-footer bg-white p-a-5">
		main footer
    </footer>-->
    <!-- END: .main-footer -->
 </div>
		      

<?php $v->start("scripts"); ?>
    <script type="text/javascript">
		$(function () {
			
			Highcharts.setOptions({
                lang: {
                    decimalPoint: ',',
                    thousandsSep: '.'
                }
            });

            var chart = Highcharts.chart('grafico', {
                chart: {
                    type: 'areaspline',
                    spacingBottom: 0,
                    spacingTop: 5,
                    spacingLeft: 0,
                    spacingRight: 0,
                },
                title: null,
                xAxis: {
                    categories: [<?= $chart->categories;?>],
                    minTickInterval: 1/30
                },
                yAxis: {
                    allowDecimals: true,
                    title: null,
                },
                tooltip: {
                    shared: true,
                    valueDecimals: 2,
                    valuePrefix: 'R$ '
                },
                credits: {
                    enabled: false
                },
                plotOptions: {
                    areaspline: {
                        fillOpacity: 0.5
                    }
                },
                series: [{
                    name: 'Receitas',
                    data: [<?= $chart->income;?>],
                    color: '#61DDBC',
                    lineColor: '#36BA9B'
                }, {
                    name: 'Despesas',
                    data: [<?= $chart->expense;?>],
                    color: '#F76C82',
                    lineColor: '#D94352'
                }]
            });
	
            $("[data-onpaidexpense]").click(function (e) {
                setTimeout(function () {
                    $.post('<?= url("/work/atualizar/{$project->id}");?>', function (callback) {
                       
                        if (callback.atualizar) {
			
							$(".atualizarvalor").text("R$ " + callback.atualizar.valor);
							$(".atualizarincomeamount").text("R$ " + callback.atualizar.wallet);
                            $(".atualizarincome").text("R$ " + callback.atualizar.income);
                            $(".atualizarexpense").text("R$ " + callback.atualizar.expense);
                        }
                    }, "json");
                }, 200);
            });
			
			
			$("[data-onpaidincome]").click(function (e) {
                setTimeout(function () {
                    $.post('<?= url("/work/atualizar/{$project->id}");?>', function (callback) {
                       
                        if (callback.atualizar) {
							$(".atualizarvalor").text("R$ " + callback.atualizar.valor);
							$(".atualizarincomeamount").text("R$ " + callback.atualizar.wallet);
                            $(".atualizarincome").text("R$ " + callback.atualizar.income);
                            $(".atualizarexpense").text("R$ " + callback.atualizar.expense);
                        }
                    }, "json");
                }, 200);
            });
			
			
			
        });
		
		
		
		
    </script>
<?php $v->end(); ?>


