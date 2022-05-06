<?php $v->layout("_theme"); ?>
	
<div class="app-main">
	<!-- begin .main-heading -->
   <!--  <header class="main-heading shadow-2dp">
		<!-- begin dashhead -->
       <!-- <div class="dashhead bg-white">
            <div class="dashhead-titles">
				<h6 class="dashhead-subtitle">
                  chaldene
                </h6>
                <h3 class="dashhead-title">Dashboard</h3>
            </div>
            <div class="dashhead-toolbar">
				<div class="dashhead-toolbar-item">
					<a href="index.html">chaldene</a>
                  / Dashboard
                </div>
            </div>
        </div>
		<!-- END: dashhead -->
    <!--  </header>-->
    <!-- END: .main-heading -->
	
    <!-- begin .main-content -->
	<div class="main-content bg-clouds">
	    <!-- begin .container-fluid -->
        <div class="container-fluid p-t-15">
		
		<div class="cafecontrol_main_box">
		
			<section class="cafecontrol_main_left">
				<article class="cafecontrol_widget">
					<header class="cafecontrol_widget_title">
						<h2><i class="fa fa-i fa-bar-chart"></i>Controle</h2>
					</header>
					<div id="control"></div>
				</article>

				<div class="cafecontrol_main_left_fature">
					<article class="cafecontrol_widget cafecontrol_widget_balance">
						<header class="cafecontrol_widget_title">
						<h2><i class="fa fa-i fa-calendar-minus-o"></i>À receber:</h2>
						</header>
						<div class="cafecontrol_widget_content">
							<?php if (!empty($income)): ?>
								<?php foreach ($income as $incomeItem): ?>
									<?= $v->insert("views/balance", ["invoice" => $incomeItem->data()]); ?>
								<?php endforeach; ?>
							<?php else: ?>
								<div class="message success al-center">
									<span class="fa fa-i fa-check-square-o"></span>	
									No momento, não existem contas a receber.
								</div>
							<?php endif; ?>
							<a href="<?= url("work/receber"); ?>" title="Receitas"
							class="cafecontrol_widget_more transition">+ Receitas</a>
						</div>
					</article>

					<article class="cafecontrol_widget cafecontrol_widget_balance">
						<header class="cafecontrol_widget_title">
						<h2><i class="fa fa-i fa-calendar-check-o"></i>À pagar:</h2>
						</header>
						<div class="cafecontrol_widget_content">
							<?php if (!empty($expense)): ?>
								<?php foreach ($expense as $expenseItem): ?>
									<?= $v->insert("views/balance", ["invoice" => $expenseItem->data()]); ?>
								<?php endforeach; ?>
							<?php else: ?>
								<div class="message error al-center">
									<span class="fa fa-i fa-check-square-o"></span>	
									No momento, não existem contas a pagar.
								</div>
							<?php endif; ?>
							<a href="<?= url("work/pagar"); ?>" title="Despesas"
							class="cafecontrol_widget_more transition">+ Despesas</a>
						</div>
					</article>
				</div>
				
				<div class="cafecontrol_main_left_fature">
					<article class="cafecontrol_widget cafecontrol_widget_balance">
						<header class="cafecontrol_widget_title">
						<h2><i class="fa fa-i fa-building"></i>Projetos:</h2>
						</header>
						<div class="cafecontrol_widget_content">
							<?php if (!empty($works)): ?>
								<?php foreach ($works as $works): ?>
									<?= $v->insert("views/works", ["work" => $works]); ?>
								<?php endforeach; ?>
							<?php else: ?>
								<div class="message success al-center">
									<span class="fa fa-i fa-check-square-o"></span>	

									No momento, não existem projetos
								</div>
							<?php endif; ?>
						</div>
					</article>
					
					<article class="cafecontrol_widget cafecontrol_widget_balance">
						<header class="cafecontrol_widget_title">
						<h2><i class="fa fa-i fa-tasks"></i>Etapas:</h2>
						</header>
						<div class="cafecontrol_widget_content">
							<?php if (!empty($stages)): ?>
								<?php foreach ($stages as $stages): ?>
									<?= $v->insert("views/stage", ["stage" => $stages]); ?>
								<?php endforeach; ?>
							<?php else: ?>
								<div class="message success al-center">
									<span class="fa fa-i fa-check-square-o"></span>	

									No momento, não existem etapas.
								</div>
							<?php endif; ?>
						</div>
					</article>	
				</div>
				
				<div class="cafecontrol_main_left_fature">
					<article class="cafecontrol_widget cafecontrol_widget_balance">
						<header class="cafecontrol_widget_title">
						<h2><i class="fa fa-i fa-tasks"></i>Tarefas:</h2>
						</header>
						<div class="cafecontrol_widget_content">
							<?php if (!empty($tasks)): ?>
								<?php foreach ($tasks as $tasks): ?>
									<?= $v->insert("views/tasks", ["task" => $tasks]); ?>
								<?php endforeach; ?>
							<?php else: ?>
								<div class="message success al-center">
									<span class="fa fa-i fa-check-square-o"></span>	

									No momento, não existem tarefas
								</div>
							<?php endif; ?>
						</div>
					</article>
				</div>
			</section>
			
			
			

			<section class="cafecontrol_main_right">
				<ul class="cafecontrol_header_widget">
						<li class="radius wallet"><span class="fa fa-i fa-filter"></span>  
						
						
						   <?php if (session()->has("walletfilter")) {
							   
								if (session()->walletfilter == "anual") {
									echo "Saldo Anual";
								} else if (session()->walletfilter == "mensal") {
									echo "Saldo Mensal";
								} else { 
									$appwalletid = (new \Source\Models\CafeApp\AppWallet())->findById(session()->walletfilter); 
									echo $appwalletid->wallet;
								}  
								
							} else {
								echo "Saldo Geral"; 
							}
						   
							?>
							<ul>
								<?php if (session()->has("walletfilter")): ?>
									<li class="radius" data-walletfilter="<?= url("/work/dash"); ?>"
										data-wallet="all"><span class="fa fa-i fa-briefcase"></span>Saldo Geral
									</li>
								<?php endif; ?>
								
								<li class="radius" data-walletfilter="<?= url("/work/dash"); ?>"
									data-wallet="anual"><span class="fa fa-i fa-briefcase"></span>Saldo Anual
								</li>
								
								<li class="radius" data-walletfilter="<?= url("/work/dash"); ?>"
									data-wallet="mensal"><span class="fa fa-i fa-briefcase"></span>Saldo Mensal
								</li>

							<?php
							$userId = user()->application_id;
							$wallets = (new \Source\Models\CafeApp\AppWallet())
								->find("application_id = :application_id AND status = 'active'", "application_id={$userId}")
								->order("wallet")
								->fetch(true);

							foreach ($wallets as $walletIt):
								if (!session()->has("walletfilter") || $walletIt->id != session()->walletfilter):
									?>
									<li class="radius" data-walletfilter="<?= url("/work/dash"); ?>"
										data-wallet="<?= $walletIt->id; ?>"><span class="fa fa-i fa-suitcase"></span>
										
										
										<?= $walletIt->wallet; ?></li>
									<?php
								endif;
							endforeach;
							?>
						</ul>
					</li>
					
				</ul>
			
			
				<ul class="cafecontrol_widget_shortcuts">
					<li class="income radius transition" data-modalopen=".cafecontrol_modal_income">
						<p><i class="fa fa-i fa-plus-circle"></i>Receita</p>	
					</li>
					<li class="expense radius transition" data-modalopen=".cafecontrol_modal_expense">
						<p><i class="fa fa-i fa-plus-circle"></i>Despesa</p>
					</li>
				</ul>
				<article class="cafecontrol_flex cafecontrol_wallet <?= ($wallet->balance == "positive" ? "gradient-green" : "gradient-red"); ?>">
					<header class="cafecontrol_flex_title">
						<?php if (session()->has("walletfilter")) {
							   
								if (session()->walletfilter == "anual") {
									$walletfilter = "Saldo Anual";
								} else if (session()->walletfilter == "mensal") {
									$walletfilter = "Saldo Mensal";
								} else { 
									$appwalletid = (new \Source\Models\CafeApp\AppWallet())->findById(session()->walletfilter); 
									$walletfilter = $appwalletid->wallet;
								}  
								
							} else {
								$walletfilter ="Saldo Geral"; 
							}
						   
						?>
					
					
						<?php if ($walletfilter == "Saldo Geral"): ?>
							<h2 class="radius"><i class="fa fa-i fa-money"></i>Saldo Geral
							
						<?php elseif ($walletfilter == "Saldo Anual"): ?>
							<h2 class="radius"><i class="fa fa-i fa-money"></i>Saldo Anual
							<h2 class="radius"><?= date("Y"); ?></h2>
						
						<?php elseif ($walletfilter == "Saldo Mensal"): ?>
							<h2 class="radius"><i class="fa fa-i fa-money"></i>Saldo Mensal
							<h2 class="radius"><?= date("m"); ?></h2>

						
						<?php else:?>
							<h2 class="radius"><i class="fa fa-i fa-money"></i>Saldo Mensal	
						
						<?php endif;?>
					</header>

					<p class="cafecontrol_flex_amount">R$ <?= str_price(($wallet->wallet ?? 0)); ?></p>
					<p class="cafecontrol_flex_balance">
						<span class="income">Receitas Recebidas: R$ <?= str_price(($wallet->income ?? 0)); ?></span>
						<span class="expense">Despesas Pagas: R$ <?= str_price(($wallet->expense ?? 0)); ?></span>
						<span class="incomeunpaid">Receitas a Receber: R$ <?= str_price(($wallet->incomeunpaid ?? 0)); ?></span>
						<span class="expenseunpaid">Despesas a Pagar: R$ <?= str_price(($wallet->expenseunpaid ?? 0)); ?></span>
						
						<?php if ($walletfilter == "Saldo Geral"): ?>
						
								<span class="projectcost">Valor Total do Projetos: R$ <?= str_price(($wallet->projectcost ?? 0)); ?></span>


						<?php elseif ($walletfilter == "Saldo Anual"): ?>
						
							<span class="projectcost">Valor Total do Projetos Anual: R$ <?= str_price(($wallet->projectcost ?? 0)); ?></span>
	
	
				
	
						<?php elseif ($walletfilter == "Saldo Mensal"): ?>
						
							<span class="projectcost">Valor Total do Projetos Mensal: R$ <?= str_price(($wallet->projectcost ?? 0)); ?></span>
						
						
	
						<?php else:?>
						
							<span class="projectcost">Valor do Projeto: R$ <?= str_price(($wallet->projectcost ?? 0)); ?></span>
	
	
	
						

						<?php endif; ?>
					</p>
				</article>
			</section>
			

		</div>
			
			
		<!-- END: .row -->
		</div>
	<!-- END: .container-fluid -->
	</div>
    <!-- END: .main-content -->
    <!-- begin .main-footer -->
   
    <!-- END: .main-footer -->
</div>
 <!-- END: .app-main -->	
	

<?php $v->start("scripts"); ?>
    <script type="text/javascript">
        $(function () {
            Highcharts.setOptions({
                lang: {
                    decimalPoint: ',',
                    thousandsSep: '.'
                }
            });

            var chart = Highcharts.chart('control', {
                chart: {
                    type: 'areaspline',
                    spacingBottom: 0,
                    spacingTop: 5,
                    spacingLeft: 0,
                    spacingRight: 0,
                    height: (9 / 16 * 100) + '%'
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

            $("[data-onpaid]").click(function (e) {
                setTimeout(function () {
                    $.post('<?= url("/work/dash");?>', function (callback) {
                        if (callback.chart) {
                            chart.update({
                                xAxis: {
                                    categories: callback.chart.categories
                                },
                                series: [{
                                    data: callback.chart.income
                                }, {
                                    data: callback.chart.expense
                                }]
                            });
                        }

                        if (callback.wallet) {
							
							
                            $(".cafecontrol_wallet").removeClass("gradient-red gradient-green").addClass(callback.wallet.status);
                            $(".cafecontrol_flex_amount").text("R$ " + callback.wallet.wallet);
                            $(".cafecontrol_flex_balance .income").text("Receitas: " + "R$ " + callback.wallet.income);
                            $(".cafecontrol_flex_balance .expense").text("Despesas: " + "R$ " + callback.wallet.expense);
							$(".cafecontrol_flex_balance .incomeunpaid").text("Receitas a Receber: " + "R$ " + callback.wallet.incomeunpaid);
                            $(".cafecontrol_flex_balance .expenseunpaid").text("Despesas a Pagar: " + "R$ " + callback.wallet.expenseunpaid);
							
							<?php if ($walletfilter == "Saldo Geral"): ?>				
								$(".cafecontrol_flex_balance .projectcost").text("Valor Total dos Projetos: " + "R$ " + callback.wallet.projectcost);
								
							<?php elseif ($walletfilter == "Saldo Anual"): ?>				
								$(".cafecontrol_flex_balance .projectcost").text("Valor Total dos Anual: " + "R$ " + callback.wallet.projectcost);	
								
							<?php elseif ($walletfilter == "Saldo Mensal"): ?>				
								$(".cafecontrol_flex_balance .projectcost").text("Valor Total dos Mensal: " + "R$ " + callback.wallet.projectcost);

							<?php else: ?>	
								$(".cafecontrol_flex_balance .projectcost").text("Valor Total do  Projeto: " + "R$ " + callback.wallet.projectcost);
								
							
							<?php endif; ?>
							
							
                        }
                    }, "json");
                }, 200);
            });
        });
    </script>
<?php $v->end(); ?>