<?php $v->layout("_theme"); ?>

 <div class="main-content bg-clouds">
    <!-- begin .container-fluid -->
    <div class="container-fluid p-t-15">
        <div class="box">
            <header class="bg-primary">
				<h4>Novo Funcionário</h4>
            </header>	
		</div>
	
		<form class="form-horizontal" action="<?= url("/work/user-add"); ?>" method="post">
			<input type="hidden" name="action" value="create"/>
					
			<div class="form-row">
			    <div class="form-group">
					<div class="col-md-6">
						<label for="first_name">*Nome:</label>
						<input type="text" class="form-control" id="first_name" name="first_name" placeholder="Primeiro nome" required/>
					</div>
					<div class="col-md-6">
						<label for="last_name">*Sobrenome:</label>
						<input type="text" class="form-control" id="last_name" placeholder="Último nome" name="last_name" required/>
					</div>
				</div>
            </div>
							
			<div class="form-row">
				<div class="form-group">
					<div class="col-md-12">
						<label for="genre">Genero:</label>
						<select class="form-control" name="genre">
							<option value="male">Masculino</option>
							<option value="female">Feminino</option>
							<option value="other">Outros</option>
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
						<label for="datebirth">Nascimento</label>
                        <input type="text" class="form-control mask-date" name="datebirth" placeholder="dd/mm/yyyy"/>
					</div>
					<div class="col-md-6">
						<label for="document">CPF</label>
                        <input class="form-control mask-doc" type="text" name="document" placeholder="CPF do usuário"/>
					</div>
				</div>
            </div>
				
			<div class="form-row">
			    <div class="form-group">
					<div class="col-md-10">
						<label for="email">Email:</label>
                        <input class="form-control" type="email" name="email" placeholder="Melhor e-mail" required/>
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
                            <option value="1">Usuário</option>
                            <option value="5">Admin</option>
                        </select>
					</div>
				</div>
            </div>

			<div class="form-row">
			    <div class="form-group">
					<div class="col-md-12">
						<label for="status">Complemento</label>
						 <select class="form-control" name="status" required>
                            <option value="registered">Registrado</option>
                            <option value="confirmed">Confirmado</option>
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




