
<!-- BEGIN: nav-content -->
 <ul class="metismenu nav nav-inverse nav-bordered nav-stacked" data-plugin="metismenu">
 
			<li>
                <a title="Usuários" href="<?= url("/work");?>">
					<span class="nav-icon">
						<i class="fa fa-fw fa-home"></i>
					</span>		
                    <span class="nav-title">Controle</span>
                </a>
            </li>
		 
			<li>
                <a title="Clientes" href="<?= url("/work/customer"); ?>">
					<span class="nav-icon">
						<i class="fa fa-fw fa-users"></i>
					</span>		
                     <span class="nav-title">Clientes</span>
                </a>
            </li>
		
            <li>
                <a title="Projetos" href="<?= url("/work/works"); ?>">
					<span class="nav-icon">
						<i class="fa fa-building"></i>
					</span>		
                     <span class="nav-title">Projetos</span>
                </a>
            </li>
		
            <li>
                <a title="Fornecedores" href="<?= url("/work/supplier"); ?>" >
					<span class="nav-icon">
						<i class="fa fa-industry"></i>
					</span>		
                    <span class="nav-title">Fornecedores</span>
                </a>
            </li>
		
			
			<!-- END: Clientes -->	
			
			<!-- BEGIN: Categorias -->
			<li>
				<a href="javascript:;">
					<span class="nav-icon"><i class="fa fa-fw fa-dollar"></i></span>                    
					<span class="nav-title">Financeiro</span>
					<span class="nav-tools"><i class="fa fa-fw arrow"></i>
				</a>
				<ul class="nav nav-sub nav-stacked">
					<li><a title="Carteiras Ativas" href="<?= url("/work/carteiras");?>">Carteiras</a></li>
					<li><a title="Carteiras Inativas" href="<?= url("/work/carteirasinativas");?>">Carteiras Inativas</a></li>
					<li><a title="Contas a Receber" href="<?= url("/work/receber");?>">Receber</a></li>
					<li><a title="Contas a Pagar" href="<?= url("/work/pagar");?>">Pagar</a></li>
					<li><a title="Faturas Fixas" href="<?= url("/work/fixas");?>">Fixas</a></li>
					<li><a title="Faturas" href="<?= url("/work/faturas");?>">Faturas</a></li>
				</ul>
			</li>
			
			
			<!-- BEGIN: Categorias -->
			<li>
				<a href="javascript:;">
					<span class="nav-icon"><i class="fa fa-fw fa-th"></i></span>                    
					<span class="nav-title">Relatorios</span>
					<span class="nav-tools"><i class="fa fa-fw arrow"></i>
				</a>
				<ul class="nav nav-sub nav-stacked">
					<li><a title="Fluxo de Caixa" href="<?= url("/work/fluxodecaixa"); ?>">Fluxo de Caixa</a></li>
		
				</ul>
				<ul class="nav nav-sub nav-stacked">
					<li><a title="Balanço Financeiro" href="<?= url("/work/balançofinanceiro"); ?>">Balanço Financeiro</a></li>
		
				</ul>
				
			</li>
			
			
			<!-- BEGIN: Categorias -->
			<li>
				<a href="javascript:;">
					<span class="nav-icon"><i class="fa fa-fw fa-th"></i></span>                    
					<span class="nav-title">Categorias</span>
					<span class="nav-tools"><i class="fa fa-fw arrow"></i>
				</a>
				<ul class="nav nav-sub nav-stacked">
					<li><a title="Faturas" href="<?= url("/work/category"); ?>">Faturas</a></li>
					<li><a title="Faturas" href="<?= url("/work/service-category"); ?>">Serviços</a></li>

				</ul>
			</li>
			
			
			<li>
                <a title="Usuários" href="<?= url("/work/user");?>">
					<span class="nav-icon">
						<i class="fa fa-fw fa-user"></i>
					</span>		
                    <span class="nav-title">Usuários</span>
                </a>
            </li>
				
		
               
        
			
				<!-- <li>
                <a title="Perfil" href="<?= url("/work/perfil");?>">
					<span class="nav-icon">
						<i class="fa fa-fw fa-exchange"></i>
					</span>		
                    <span class="nav-title">Perfil</span>
                </a>
            </li>-->
			
			<!--<li>
                <a title="Assinatura" href="<?= url("/work/assinatura");?>">
					<span class="nav-icon">
						<i class="fa fa-fw fa-coffee"></i>
					</span>		
                    <span class="nav-title">Assinatura</span>
                </a>
            </li>-->
			
			<li>
                <a title="Suporte" type="button">
					<span class="nav-icon">
						<i class="fa fa-fw fa-life-ring"></i>
					</span>		
                    <span style="cursor: pointer;" class="nav-title" data-modalopen=".cafecontrol_modal_contact">Suporte</span>
                </a>
            </li> 
			
			<li>
                <a title="Sair" href="<?= url("/work/sair");?>">
					<span class="nav-icon">
						<i class="fa fa-fw fa-sign-out"></i>
					</span>		
                    <span class="nav-title">Sair</span>
                </a>
            </li>	      
  </ul>              
     
	
	
	



