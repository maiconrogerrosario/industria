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
						<h3>Categoria de Etapas</h3>
						<div class="box-tools">
						</div>
					</header>
				</div>
				
				<a href="<?= url("/work/stage-category-add"); ?>" class="btn btn-primary"><i class='fa fa-fw fa-plus-circle'></i>Novo Categoria de Etapas</a>
				<br><br>
				
			<div class="card-content table-responsive">
	
				<table class="table table-bordered table-hover">
					<thead>
						<th scope="col" style="text-align:center;font-size:12px;">NOME</th>
						<th scope="col" style="text-align:center;font-size:12px;">AÇÕES</th>
					</thead>
					<tbody>	
					<?php if (!empty($categories)): ?>
						<?php foreach ($categories as $categorie):?>
						<tr scope="row">
							<td scope="col" style="text-align:center;font-size:12px;"><?php echo $categorie->name;?></td>
							<td scope="col" style="text-align:center;font-size:12px;">
							<a class="btn-simple btn btn-danger btn-xs" title="" href="#"
                                data-post="<?= url("/work/stage-category-delete/{$categorie->id}"); ?>"
                                data-action="delete"
                                data-confirm="Tem que deseja deletar essa vinculação?"
                                data-id="<?= $categorie->id;?>"><i class='fa fa-fw fa-remove'></i>Deletar</a> 
							</td>
						</tr>
						<?php endforeach; ?>
					 <?php endif; ?>			
					</tbody>
				</table>			
			</div>
			</div>	
		</div>
	</div>
</div>



		


		

