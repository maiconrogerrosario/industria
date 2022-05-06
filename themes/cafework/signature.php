<?php $v->layout("_theme"); ?>

<div class="app-main">
    <!-- begin .main-heading -->
    <!--<header class="main-heading shadow-2dp">
		begin dashhead 
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
		<!-- END: dashhead 
    </header>-->
    <!-- END: .main-heading -->
    <!-- begin .main-content -->
    <div class="main-content bg-clouds">
		<!-- begin .container-fluid -->
        <div class="container-fluid p-t-15">
            <!-- BEGIN: .row -->
            <div class="row">
				<div class="col-xs-12">
					<div class="box">  
						
							<?php if (!empty($subscription)): ?>
								<article class="cafecontrol_signature cafecontrol_signature_me radius">
									<?php if ($subscription->status == "past_due"): ?>
										<div class="message warning "><i class="fa fa-i fa-warning"></i>
											Importante <?= user()->first_name; ?>: Não foi possível cobrar seu cartão e sua assinatura está
											atrasada, para não perder os recursos PRO é preciso regularizar seu pagamento.
											<p style="margin-top: 20px">Cadastre um novo cartão de crédito <span data-go=".payment" class="message_btn">CLICANDO AQUI</span></p>
										</div>
									<?php endif; ?>

										<header class="cafecontrol_signature_me_header">
											<h1>Minha assinatura:</h1>
											<p>Confira detalhes da sua assinatura</p>
										</header>

										<ul class="cafecontrol_signature_detail radius">
											<li><span>Status:</span> <span><?= ($subscription->status == "active" ? "Ativa" : "Atrasada"); ?></span>
											</li>
											<li><span>Plano:</span> <span><?= $subscription->plan()->name; ?></span></li>
											<li><span>Início:</span> <span><?= date_fmt($subscription->started, "d/m/Y"); ?></span></li>
											<li><span>Valor:</span> <span>R$ <?= str_price($subscription->plan()->price); ?></span></li>
											<li><span>Cartão:</span>
											<span style="text-transform: uppercase"><?= $subscription->creditCard()->brand; ?> Final <?= $subscription->creditCard()->last_digits; ?></span>
											</li>
											<li><span>Próximo pagamento:</span> <span><?= date_fmt($subscription->next_due, "d/m/Y"); ?></span></li>
										</ul>

										<div class="cafecontrol_signature_me_header">
											<h2>Meus Pagamentos:</h2>
											<p>Confira detalhes de seus pagamentos</p>
										</div>
	
										<div class="cafecontrol_signature_orders">
											<?php if (empty($orders)): ?>
												<div class="message info  al-center"><i class="fa fa-i fa-info" ></i>Ainda não existem faturas para sua assinatura. Quando
													existirem, você poderá conferi-las aqui.
												</div>
											<?php else: ?>
												<div class="cafecontrol_signature_orders_item title">
													<p>Data</p>
													<p>Valor</p>
													<p>Cartão</p>
												</div>
												<?php foreach ($orders as $order):
													$status = ($order->status == "paid" ? '<span class="icon-check" title="Paga"></span>' : ($order->status == "waiting" ? '<span class="icon-clock-o" title="Aguardando Pagamento"></span>' : '<span class="icon-error" title="Recusada"></span>')); ?>
													<article class="cafecontrol_signature_orders_item">
														<p>
															<?= $status; ?> <?= date_fmt($order->created_at, "d/m/Y"); ?>
															<sup>#<?= $order->transaction; ?></sup>
														</p>
														<p>R$ <?= str_price($order->amount); ?></p>
														<p style="text-transform: uppercase;"><?= $order->creditCard()->brand; ?>
														Final <?= $order->creditCard()->last_digits; ?></p>
													</article>
												<?php endforeach; ?>
											<?php endif; ?>
										</div>

										<div class="cafecontrol_signature_me_header payment">
											<h2>Meio de pagamento:</h2>
											<p>Precisa usar um novo cartão de crédito?</p>
										</div>

									<div class="cafecontrol_signature_pay_card">
										<?php $v->insert("views/signature",
											["plans" => null, "action" => url("/pay/update"), "btn_cafecontrol" => "Cadastrar Cartão"]); ?>
									</div>
								</article>
								<?php else: ?>
									<article class="cafecontrol_signature radius">
										<header class="cafecontrol_signature_header gradient gradient-green">
											<span><i class="fa fa-i fa-5x fa-coffee fa fa-i fa-notext"></i></span>
											<h2>Seja PRO por apenas R$ 0,16 centavos por dia e controle tudo!</h2>
											<p>Crie multiplas carteiras para controlar suas finanças PF, PJ, contas bancárias, cartões de crédito,
											poupanças... e libere o controle absoluto de suas contas.</p>
										</header>

										<section class="cafecontrol_signature_resources">
											<div class="cafecontrol_signature_resources_overflow">
												<h3>Compare as versões FREE e PRO e entenda!</h3>
												<div class="cafecontrol_signature_resources_item title">
													<p class="resouce">Recurso</p>
													<p class="check"><i class="fa fa-i fa-user-plus"></i>FREE</p>
													<p class="check"><i class="fa fa-i fa-coffee"></i>PRO</p>
												</div>
												<article class="cafecontrol_signature_resources_item">
													<p class="resouce">Contas a receber</p>
													<p class="check"><i class="fa fa-i fa-check"></i></p>
													<p class="check"><i class="fa fa-i fa-check"></i></p>
												</article>
												<article class="cafecontrol_signature_resources_item">
													<p class="resouce">Contas a pagar</p>
													<p class="check"><i class="fa fa-i fa-check"></i></p>
													<p class="check"><i class="fa fa-i fa-check"></i></p>
												</article>
												<article class="cafecontrol_signature_resources_item">
													<p class="resouce">Parcelamento</p>
													<p class="check"><i class="fa fa-i fa-check fa fa-i fa-notext"></i></p>
													<p class="check"><i class="fa fa-i fa-check fa fa-i fa-notext"></i></p>
												</article>
												<article class="cafecontrol_signature_resources_item">
													<p class="resouce">Contas a fixas</p>
													<p class="check"><i class="fa fa-i fa-check fa fa-i fa-notext"></i></p>
													<p class="check"><i class="fa fa-i fa-check fa fa-i fa-notext"></i></p>
												</article>
												<article class="cafecontrol_signature_resources_item">
													<p class="resouce">Carteiras ilimitadas</p>
													<p class="check"><i class="fa fa-i fa-close fa fa-i fa-notext"></i></p>
													<p class="check"><i class="fa fa-i fa-check fa fa-i fa-notext"></i></p>
													</article>
												<article class="cafecontrol_signature_resources_item">
													<p class="resouce">Vencimentos por e-mail</p>
													<p class="check"><i class="fa fa-i fa-close fa fa-i fa-notext"></i></p>
													<p class="check"><i class="fa fa-i fa-check fa fa-i fa-notext"></i></p>
												</article>
												<article class="cafecontrol_signature_resources_item">
													<p class="resouce">PF, PJ, cartões, etc</p>
													<p class="check"><i class="fa fa-i fa-close fa fa-i fa-notext"></i></p>
													<p class="check"><i class="fa fa-i fa-check fa fa-i fa-notext"></i></p>
												</article>
												<article class="cafecontrol_signature_resources_item">
													<p class="resouce">Filtro por fonte (carteira)</p>
													<p class="check"><i class="fa fa-i fa-close fa fa-i fa-notext"></i></p>
													<p class="check"><i class="fa fa-i fa-check fa fa-i fa-notext"></i></p>
												</article>
												<article class="cafecontrol_signature_resources_item">
													<p class="resouce">Controle de saldo geral</p>
													<p class="check"><i class="fa fa-i fa-close fa fa-i fa-notext"></i></p>
													<p class="check"><i class="fa fa-i fa-check fa fa-i fa-notext"></i></p>
												</article>
											</div>
										</section>

										<article class="cafecontrol_signature_pay">
											<?php if (!$plans): ?>
												<div class="message info al-center">Desculpe <?= user()->first_name; ?>, mas no momento não existem
													planos
													para assinatura :/
												</div>
											<?php else: ?>
												<header>
													<h2><i class="fa fa-i fa-coffee"></i>Assine o PRO</h2>
													<p>E libere todos os recursos do Cafécafecontrol_</p>
												</header>
												<div class="cafecontrol_signature_pay_card">
													<?php $v->insert("views/signature", ["plans" => $plans, "action" => url("/pay/create")]); ?>
												</div>
											<?php endif; ?>
										</article>
									</article>
							<?php endif; ?>
						
					</div>
				</div>		
			</div>
		</div>
	</div>
</div>

		      

 





