<!doctype html>
<html>
<head>
    
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">


	
	<!-- END: theme main stylesheet files -->
	
	<style>
	
      


        table.blueTable {
            background:	#FFF;		
            width: 100%;
            text-align: left;
            border-collapse: collapse;
            font-family: 'Open Sans', sans-serif;
		
				
        }
		
		
		th, td {
			text-align: left;
			padding: 5px;
		}

		

        table.blueTable td,
        table.blueTable th {
			align-items: center;
			padding: 15px 0;
			font-size: 12px;
			text-transform: uppercase;
				border-bottom: 1px solid #ddd;

      	
        }
		

        table.blueTable tbody td {
            font-size: 10px;
        }

        

        table.blueTable thead {
           border-bottom: 2px solid #ddd;
        }

        table.blueTable thead tr th {
		
            background: none;
			font-size: .7em;
			text-transform: uppercase;
			
        }

        table.blueTable tfoot td {
            font-size: 14px;
        }

        table.blueTable tfoot .links {
            text-align: right;
        } table.blueTable {
            background:	#FFF;		
            width: 100%;
            text-align: left;
            border-collapse: collapse;
            font-family: 'Open Sans', sans-serif;
		
				
        }
		
		
		th, td {
			text-align: left;
			padding: 5px;
		}

		

        table.blueTable td,
        table.blueTable th {
			align-items: center;
			padding: 15px 0;
			font-size: 12px;
			text-transform: uppercase;
				border-bottom: 1px solid #ddd;

      	
        }
		

        table.blueTable tbody td {
            font-size: 10px;
        }

        

        table.blueTable thead {
           border-bottom: 2px solid #ddd;
        }

        table.blueTable thead tr th {
		
            background: none;
			font-size: .7em;
			text-transform: uppercase;
			
        }

        table.blueTable tfoot td {
            font-size: 14px;
        }

        table.blueTable tfoot .links {
            text-align: right;
        }
		



    </style>
	
	
	
</head>
<body>
	
	
					<?php if (session()->has("walletfilter")): ?>
								<li class="radius" data-walletfilter="<?= url("/work/dash"); ?>"
									data-wallet="all"><span class="fa fa-i fa-briefcase"></span>Saldo Geral
								</li>
							<?php endif; ?>

							<?php
							$userId = user()->application_id;
							$wallets = (new \Source\Models\CafeApp\AppWallet())
								->find("application_id = :application_id", "application_id={$userId}")
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
	
 
           
                
										
											
												
												<table class="blueTable">
												
													<thead>
														<tr>
							
															<th scope="col" style="text-align:center;">DESCRIÇÃO</th>
															<th scope="col" style="text-align:center;">VENCIMENTO</th>
															<th scope="col" style="text-align:center;">CARTEIRA</th>
															<th scope="col" style="text-align:center;">TIPO</th>
															<th scope="col" style="text-align:center;">CATEGORIA</th>
															<th scope="col" style="text-align:center;">PARCELA</th>
															<th scope="col" style="text-align:center;">VALOR</th>
															
															
														</tr>	
													</thead>
													
													<tbody>	
													<?php
													$unpaid = 0;
													$paid = 0;
													foreach ($invoices as $invoice):
													
													$wallet = $invoice->getWallet();
													
													?>
													<tr scope="row">
														<td style="text-align:center;">
															<span>
																<a 
																	><?= str_limit_words($invoice->description,
																	6,) ?>
																</a>
															</span>
														</td>
														<td  style="text-align:center;" > <?= date_fmt($invoice->due_at, "d/m/y"); ?></td>
														<td  style="text-align:center"> <?= $wallet->wallet; ?></td>
														<td  style="text-align:center">
																
															<?php if ($invoice->type == 'income'): ?>
																<span>Receitas</span>
															<?php else: $paid += $invoice->value; ?>
																<span>Despesas</span>

															<?php endif; ?>	
																	
														</td>
														<td style="text-align:center" ><?= $invoice->category()->name; ?></td>
														<td  style="text-align:center">
															<?php if ($invoice->repeat_when == "fixed"): ?>
																<span>
																	<a href="<?= url("/work/fatura/{$invoice->invoice_of}"); ?>" 
																	title="Controlar Conta Fixa"><i></i>Fixa</a>
																	</span>
															<?php elseif ($invoice->repeat_when == 'enrollment'): ?>
																<span>
																	<a href="<?= url("/work/fatura/{$invoice->invoice_of}"); ?>"
																		title="Controlar Parcelamento"><?= str_pad($invoice->enrollment_of, 2, 0,
																		0); ?> de <?= str_pad($invoice->enrollments, 2, 0, 0); ?></a>
																</span>
															<?php else: ?>
																<span>Única</span>
															<?php endif; ?>
														</td>
														<td style="text-align:center">
														
															<span>R$ <?= str_price($invoice->value); ?></span>
											
														</td>
													</tr>
													<?php endforeach; ?>
												</tbody>
													
												</table>			
										
											
								
							<table>
								<tbody>
						
									<tr scope="row">
										<tr scope="row">
											<td><strong>Saldo: R$</td>
											<td><?=  $walletr->wallet; ?><td>
										</tr>
										<tr scope="row">
											<td><strong>Receitas: R$</strong></td><td><?= str_price($walletr->income); ?><td>
										</tr>
										<tr scope="row">
											<td><strong>Despesas: R$</strong></td><td><?= str_price($walletr->expense); ?><td>
										</tr scope="row">
										
									</tr>	
								</tbody>								
							</table>
								
							<?php var_dump($walletr); ?>

									

 



</body>
</html>
