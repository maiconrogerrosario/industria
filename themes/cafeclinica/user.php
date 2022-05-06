<?php $v->layout("_theme"); ?>

<div class="app-main">
	<div class="row">
		<div class="col-md-12">
			<div class="btn-group pull-right">
				<!--<div class="btn-group pull-right">
					<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-download"></i> Descargar <span class="caret"></span>
					</button>
					<ul class="dropdown-menu" role="menu">
						<li><a href="report/clients-word.php">Word 2007 (.docx)</a></li>
					</ul>
				</div>-->
			</div>
			<div class="container-fluid p-t-15">
				<div class="box">
					<header>
						<h3>Usuários</h3>
						<div class="box-tools">
						</div>
					</header>
				</div>
			<div class="card-content table-responsive">
				<a href="<?= url("/work/user-add"); ?>" title="Cadastrar Novo Usuário" class="btn btn-primary"><i class='fa fa-fw fa-plus-circle'></i>Novo Usuário</a>
				<br><br>

				<table class="table table-bordered table-hover">
					<thead>
						<th>Nome</th>
						<th>Sobrenome</th>
						<th>Email</th>
						<th>Ações</th>		
					</thead>
					<tbody>
						<?php foreach ($users as $user):?>
							<tr>
								<td><?php echo $user->first_name; ?></td>
								<td><?php echo $user->last_name; ?></td>
								<td><?php echo $user->email; ?></td>										
								<td style="width:280px;">
								<!--<a href="" class="btn btn-primary btn-xs">Historico</a>-->
								<a href="<?= url("/work/user-edit/{$user->id}"); ?>" title="Editar Usuário" class="btn btn-warning btn-xs">Editar</a>
								<a class="btn btn-danger btn-xs" title="Deletar Usuário" href="#"
									data-post="<?= url("/work/user-delete/{$user->id}"); ?>"
									data-action="delete"
									data-confirm="Tem certeza que deseja deletar esse Usuario?"
									data-user_id="<?= $user->id; ?>">Deletar</a>
								</td>
							</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			</div>
		</div>	
	</div>
</div>

		








