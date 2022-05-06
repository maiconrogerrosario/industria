
<!-- BEGIN: nav-content -->
 <ul class="metismenu nav nav-inverse nav-bordered nav-stacked" data-plugin="metismenu">
 
            <li>
				<a title="Home" href="<?= url("/clinic"); ?>" >
					<span class="nav-icon">
						<i class="fa fa-home"></i>	
					</span>	
					 <span class="nav-title">Inicio</span>
                </a>
            </li>
		
			<li>
                <a title="Consultas" href="<?= url("/clinic/scheduling"); ?>">
					<span class="nav-icon">
						<i class="fa fa-fw fa-calendar"></i>
					</span>		
                     <span class="nav-title">Agenda</span>
                </a>
            </li>
				
			<li>
                <a title="Clientes" href="<?= url("/clinic/customer"); ?>">
					<span class="nav-icon">
						<i class="fa fa-fw fa-users"></i>
					</span>		
                     <span class="nav-title">Clientes</span>
                </a>
            </li>
		
            <li>
                <a title="Consultas" href="<?= url("/clinic/customer"); ?>">
					<span class="nav-icon">
						<i class="fa fa-shopping-bag"></i>
					</span>		
                     <span class="nav-title">Vendas e Orçamentos</span>
                </a>
            </li>
            <li>
                <a title="Financeiro" href="<?= url("/work/supplier"); ?>" >
					<span class="nav-icon">
						<i class="fa fa-dollar"></i>
					</span>		
                    <span class="nav-title">Financeiro</span>
                </a>
				<ul class="nav nav-sub nav-stacked">
					<li>
						<a class="/contas-a-receber"> Contas a Receber</a>
					</li>
					<li>
						<a class="/contas-a-pagar"> Contas a Pagar </a>
					</li>
					<li>
						<a class="/categorias-conta"> Categorias de Conta </a>
					</li>
					<li>
						<a class="/formas-de-pagamento"> Formas de Pagamento </a>
					</li>
					<li>
						<a class="/contas-bancarias"> Contas Bancárias </a>
					</li>
					<li>
						<a class="/taxas-comissao"> Taxas Comissões </a>
					</li><!---->
				</ul>	
            </li>
			<li>
				<a title="Consultas" href="<?= url("/clinic/customer"); ?>">
					<span  class="nav-icon">
						<i  class="fa fa-address-card "></i>
					</span>
					<span  class="nav-title">Anamneses</span>
				</a>
			</li>
			<li>
				<a title="Consultas" href="<?= url("/clinic/customer"); ?>">
					<span  class="nav-icon">
						<i  class="fa fa-file"></i>
					</span>
					<span  class="nav-title">Receituários</span>
				</a><!---->
			</li>
			<li>
				<a  title="Consultas" href="<?= url("/clinic/customer"); ?>">
					<span  class="nav-icon">
						<i  class="fa fa-ticket"></i>
					</span>
					<span  class="nav-title">Créditos Pacotes</span>
				</a><!---->
			</li>
	<li>
		<a  title="Consultas" href="<?= url("/clinic/customer"); ?>">
			<span  class="nav-icon">
				<i  class="fa fa-edit"></i>
			</span>
			<span  class="nav-title">Cadastros</span>
		</a>
		<ul class="nav nav-sub nav-stacked">
			<li>
				<a title="Consultas" href="<?= url("/clinic/customer"); ?>">"/produtos"> Produtos </a>
			</li>
			<li>
				<a title="Consultas" href="<?= url("/clinic/customer"); ?>">"/procedimentos"> Procedimentos </a>
			</li>
			<li>
				<a title="Consultas" href="<?= url("/clinic/customer"); ?>">"/pacotes"> Pacotes </a>
			</li>
			<li>
				<a title="Consultas" href="<?= url("/clinic/customer"); ?>">"/fornecedores"> Fornecedores </a>
			</li>
			<li>
				<a title="Consultas" href="<?= url("/clinic/customer"); ?>">"/formularios-anamnese"> Modelos de Anamnese </a>
			</li>
			<li>
				<a title="Consultas" href="<?= url("/clinic/customer"); ?>">"/modelos-receita"> Modelos de Receita </a>
			</li>
			<li>
				<a title="Consultas" href="<?= url("/clinic/customer"); ?>">"/modelos-receita"> Modelos de Receita  </a>
			</li><!---->
		</ul>
		
	</li>
	<li>
		<a title="Consultas" href="<?= url("/clinic/customer"); ?>">
			<span class="nav-icon">
				<i class="fa fa-home "></i>
			</span>
			<span class="nav-title">Minha Clínica</span>
		</a>
		<ul class="nav nav-sub nav-stacked">
			<li>
				<a class="/minha-clinica"> Informações </a>
			</li>
			<li>
				<a class="/locais-procedimento"> Salas de Procedimento </a>
			</li>
			<li>
				<a class="/usuarios"> Usuários </a>
			</li><!---->
		</ul>
	</li>
	<li>
		<a title="Consultas" href="<?= url("/clinic/customer"); ?>">
			<span  class="nav-icon">
				<i  class="fa fa-paper-plane"></i>
			</span>
			<span  class="nav-title">Envio SMSs</span>
		</a><!---->
	</li>
	<li>
		<a title="Consultas" href="<?= url("/clinic/customer"); ?>">
			<span  class="nav-icon">
				<i  class="fa fa-receipt "></i>
			</span>
			<span  class="nav-title">Relatórios</span>
		</a>
		<ul class="nav nav-sub nav-stacked">
			<li>
				<a class="/relatorio-financeiro"> Financeiro </a>
			</li>
			<li>
				<a class="/relatorio-categorias-de-conta"> Categorias de Conta </a>
			</li>
			<li>
				<a class="/relatorio-fluxo-de-caixa"> Fluxo de Caixa </a>
			</li>
			<li>
				<a class="/relatorio-abc-clientes"> Curva ABC Clientes </a>
			</li>
			<li>
				<a class="/relatorio-abc-produtos"> Curva ABC Produtos e Procedimentos </a>
			</li>
			<li>
				<a class="/relatorio-agendamentos"> Agendamentos </a>
			</li>
			<li >
				<a class="/relatorio-aniversarios"> Aniversários </a>
			</li>
			<li>
				<a class="/relatorio-clientes-inativos"> Clientes Inativos </a>
			</li>
			<li>
				<a class="/relatorio-creditos-pacote"> Créditos Pacote </a>
			</li>
			<li>
				<a class="/relatorio-faltas"> Faltas </a>
			</li>
			<li>
				<a class="/relatorio-comissoes"> Comissões </a>
			</li><!---->
		</ul>
	</li>
	<li>
		<a title="Consultas" href="<?= url("/clinic/customer"); ?>">
			<span class="nav-icon">
				<i class="fa fa-question-circle "></i>
			</span>
			<span class="nav-title">Ajuda</span>
		</a><!---->
	</li><!---->
	<li>
        <a title="Usuários" href="<?= url("/work/user");?>">
			<span class="nav-icon">
				<i class="fa fa-fw fa-users"></i>
			</span>		
			<span class="nav-title">Usuários</span>
        </a>
    </li>
	<li>
        <a title="Usuários" href="<?= url("/work/work-sair");?>">
			<span class="nav-icon">
				<i class="fa fa-fw fa-label"></i>
			</span>		
            <span class="nav-title">Sair</span>
        </a>
    </li>
			
			      
</ul>              
     
	
	
	
	


