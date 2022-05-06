<?php $v->layout("_theme"); ?>

 <div class="main-content bg-clouds">
    <!-- begin .container-fluid -->
    <div class="container-fluid p-t-15">
        <div class="box">
            <header class="bg-primary">
				<h4>Nova Categoria de Equipamentos</h4>
            </header>	
		</div>
		<form class="form-horizontal" action="<?= url("/app/equipment-category-add"); ?>" method="post">
			<div class="form-group">
				<div class="col-md-12">
					<label for="name" class="control-label">Nome da Categoria</label>
					<input type="hidden" name="action" value="create"/>
					<input type="text" name="name" required class="form-control" id="name" placeholder="Nome da Categoria">
				</div>
			</div>
		
			<div class="form-group">
				<div class="col-md-12">
					<button type="submit" class="btn btn-primary">Cadastrar Categoria</button>
				</div>
			</div>
		</form>	
	</div>
</div>




