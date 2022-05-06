<!doctype html>
<html>
<head>
    
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <?= $head; ?>

	
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
        }
		



    </style>
	
	
	
</head>
<body>
	<div class="app">
      <div class="app-wrap">
   
      

<div class="app-main">
    <!-- begin .main-heading -->
    <header class="main-heading shadow-2dp">
		<!-- begin dashhead -->
		<!-- <div class="dashhead bg-white">
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
		</div> -->
		<!-- END: dashhead -->
    </header>
    <!-- END: .main-heading -->
    <!-- begin .main-content -->
 
           
                
										
											
												
												<table class="blueTable">
												
													<thead>
														<tr>
															<th  style="text-align:center;">Tipo</th>
															<th  style="text-align:center;">Descrição</th>
															<th  style="text-align:center;">Data de Início</th>
															<th  style="text-align:center;">Data de Términio</th>
															<th  style="text-align:center;">Prazo</th>
														</tr>	
													</thead>
													
													<?php if (!empty($stage)): ?>		
														<?php foreach ($stage as $stage1):?>	
														<tbody>
															<tr>
																<th scope="col" style="text-align:center;">Etapa</th>
																<th scope="col" style="text-align:center;"><?php echo  $stage1->stage_name;?></th></th>
																<th scope="col" style="text-align:center;"><?php echo ($stage1->date_initial ? date_fmt($stage1->date_initial, "d/m/Y") : null); ?></th>
																<th scope="col" style="text-align:center;"><?php echo ($stage1->date_final ? date_fmt($stage1->date_final, "d/m/Y") : null); ?></th>
																<th scope="col" style="text-align:center;"><?php echo $stage1->duration;?></th>
									
															</tr>
															
															
															<?php if (!empty($tasks)): ?>				
																<?php foreach ($tasks as $task1):?>	
																	<?php if ($stage1->stage_name ==  $task1->stage_name): ?>
																		<tr>
																			<td scope="col" style="text-align:center;">Tarefa</td>
																			<td scope="col" style="text-align:center;"><?php echo $task1->task_name;?></td>
																			<td scope="col" style="text-align:center;"><?php echo ($task1->date_initial ? date_fmt($task1->date_initial, "d/m/Y") : null);?></td>
																			<td scope="col" style="text-align:center;"><?php echo ($task1->date_final ? date_fmt($task1->date_final, "d/m/Y") : null); ?></td>
																			<td scope="col" style="text-align:center;"><?php echo $task1->duration;?></td>
																					
																			
																		</tr>
																	<?php endif; ?>	 
																<?php endforeach;?>	   
															<?php endif; ?>	   
														</tbody>	         	
															
															
														<?php endforeach;?>	   
													<?php endif; ?>	   
													
												</table>			
										
											
								
							 
								
								
									
							
		</div>			
  </div>
</div>
 



</body>
</html>
