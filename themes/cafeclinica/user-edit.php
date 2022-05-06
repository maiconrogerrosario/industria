<?php $v->layout("_theme"); ?>

 <div class="main-content bg-clouds">
    <!-- begin .container-fluid -->
    <div class="container-fluid p-t-15">
        <div class="box">
            <header class="bg-primary">
				<h4>Editar Dados do Funcionário</h4>
            </header>	
		</div>
	
		<form class="form-horizontal" action="<?= url("/work/user-edit/{$user->id}"); ?>" method="post">
			<input type="hidden" name="action" value="update"/>
					
			<div class="form-row">
			    <div class="form-group">
					<div class="col-md-6">
						<label for="first_name">*Nome:</label>
						<input type="text" class="form-control" id="first_name" name="first_name" placeholder="Primeiro nome"  value="<?= $user->first_name; ?>" required/>
					</div>
					<div class="col-md-6">
						<label for="last_name">*Sobrenome:</label>
						<input type="text" class="form-control" id="last_name" placeholder="Último nome" name="last_name" value="<?= $user->last_name; ?>" required/>
					</div>
				</div>
            </div>
							
			<div class="form-row">
				<div class="form-group">
					<div class="col-md-12">
						<label for="genre">Genero:</label>
						<select class="form-control" name="genre">
							<?php
							$genre = $user->genre;
							$select = function ($value) use ($genre) {
								return ($genre == $value ? "selected" : "");
							};
							?>
							<option <?= $select("male"); ?> value="male">Masculino</option>
							<option <?= $select("female"); ?> value="female">Feminino</option>
							<option <?= $select("other"); ?> value="other">Outros</option>
						</select>				
					</div>
				</div>					
			</div>

			<div class="form-row">
			    <div class="form-group">
					<div class="col-md-12">
						<label for="photo">Foto: (600x600px)</label>
						<input class="form-control" type="file" name="photo"/>
					</div>	
				</div>
            </div>
			
			<div class="form-row">
			    <div class="form-group">			
					<div class="col-md-6">
						<label for="datebirth">Data de Nascimento</label>
                        <input type="text" class="form-control mask-date" name="datebirth" placeholder="dd/mm/yyyy" value="<?= date_fmt($user->datebirth, "d/m/Y"); ?>" />
					</div>
					<div class="col-md-6">
						<label for="document">CPF</label>
                        <input class="form-control mask-doc" type="text" name="document" placeholder="CPF do usuário" value="<?= $user->document; ?>" />
					</div>
				</div>
            </div>
			
			
					
			<div class="form-row">
			    <div class="form-group">
					<div class="col-md-10">
						<label for="email">Email:</label>
                        <input class="form-control" type="email" name="email" placeholder="Melhor e-mail" value="<?= $user->email; ?>" required/>
					</div>
					<div class="col-md-2">
						<label for="password">Senha:</label>
                        <input class="form-control" type="password" name="password" placeholder="Senha de acesso" required/>
					</div>
				</div>
            </div>		

			<div class="form-row">
			    <div class="form-group">
					<div class="col-md-12">
						<label for="level">Bairro</label>
						<select class="form-control" class="form-control"  name="level" required>
							<?php
                            $level = $user->level;
                            $select = function ($value) use ($level) {
                                return ($level == $value ? "selected" : "");
                            };
                            ?>
                            <option <?= $select(1); ?> value="1">Usuário</option>
                            <option <?= $select(5); ?> value="5">Admin</option>
                        </select>
					</div>
				</div>
            </div>

			<div class="form-row">
			    <div class="form-group">
					<div class="col-md-12">
						<label for="status">Complemento</label>
						 <select class="form-control" name="status" required>
							<?php
                            $status = $user->status;
                            $select = function ($value) use ($status) {
                                return ($status == $value ? "selected" : "");
                            };
                            ?>
                            <option <?= $select("registered"); ?> value="registered">Registrado</option>
                            <option <?= $select("confirmed"); ?> value="confirmed">Confirmado</option>   
                        </select>
					</div>
				</div>
            </div>		
				
								
			<div class="form-row">
			    <div class="form-group">
					<div class="col-md-4">
						<button type="submit" class="btn btn-primary">Cadastrar</button>
					</div>	
				</div>
            </div>
					
		</form>		
	</div>
</div>




