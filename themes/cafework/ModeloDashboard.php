<?php $v->layout("_theme"); ?>
	
<div class="app-main">
	<!-- begin .main-heading -->
    <header class="main-heading shadow-2dp">
		<!-- begin dashhead -->
        <div class="dashhead bg-white">
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
    </header>
    <!-- END: .main-heading -->
	
    <!-- begin .main-content -->
	<div class="main-content bg-clouds">
	    <!-- begin .container-fluid -->
        <div class="container-fluid p-t-15">
            <!-- BEGIN: alert -->
            <div class="row">
                <div class="col-xs-12">
					<div class="alert alert-info alert-dismissible fade in" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h4>Welcome to Chaldene Bootstrap 3 Based Admin Toolkit</h4>
						<p>I hope you like it.</p>
					</div>
                </div>
            </div>
            <!-- END: alert -->
            <!-- begin statarea chart -->
            <div class="row">
                <div class="col-xs-6 col-sm-3">
					<div class="box p-a-0 bg-peter-river b-r-3">
						<div class="p-a-15">
							<span class="text-white">PAGE VIEWS</span>
							<div class="f-5 text-white">
								<span class="counterup">43</span>
								<span class="h4">4% <i class="fa fa-fw fa-caret-up"></i></span>
							</div>
						</div>
						<hr class="m-t-0 m-b-5 b-s-dashed">
						<div>
							<canvas width="100" height="30" data-charty="statarea" data-label="Line" data-labels="['a','b','c','d','e','f','g']" data-value="[28,68,41,43,96,45,100]" data-border-color="#ffffff" data-background-color="rgba(255, 255, 255, 0.1)"></canvas>
						</div>
					</div>
                </div>
                <div class="col-xs-6 col-sm-3">
					<div class="box p-a-0 bg-nephritis b-r-3">
						<div class="p-a-15">
							<span class="text-white">DOWNLOADS</span>
							<div class="f-5 text-white">
								<span class="counterup">896</span>
								<span class="h4">2.3% <i class="fa fa-fw fa-caret-up"></i></span>
							</div>
						</div>
						<hr class="m-t-0 m-b-5">
						<div>
							<canvas width="100" height="30" data-charty="statarea" data-label="Line" data-labels="['a','b','c','d','e','f','g']" data-value="[4,34,64,27,96,50,80]" data-border-color="#ffffff" data-background-color="rgba(255, 255, 255, 0.1)"></canvas>
						</div>
					</div>
                </div>
                <div class="clearfix visible-xs-block">
				</div>
                <div class="col-xs-6 col-sm-3">
					<div class="box p-a-0 bg-wisteria b-r-3">
						<div class="p-a-15">
							<span class="text-white">NEW VISITOR</span>
							<div class="f-5 text-white">
								<span class="counterup">1234</span>
								<span class="h4"><span class="counterup">4.02</span>% <i class="fa fa-fw fa-caret-up"></i></span>
							</div>
						</div>
						<hr class="m-t-0 m-b-5">
						<div>
							<canvas width="100" height="30" data-charty="statarea" data-label="Line" data-labels="['a','b','c','d','e','f','g']" data-value="[12,38,32,94,36,54,68]" data-border-color="#ffffff" data-background-color="rgba(255, 255, 255, 0.1)"></canvas>
						</div>
					</div>
                </div>
                <div class="col-xs-6 col-sm-3">
					<div class="box p-a-0 bg-concrete b-r-3">
						<div class="p-a-15">
							<span class="text-white">RETURN</span>
							<div class="f-5 text-white">
								<span class="counterup">91</span>
								<span class="h4">2.1% <i class="fa fa-fw fa-caret-down text-alizarin"></i></span>
							</div>
						</div>
						<hr class="m-t-0 m-b-5">
						<div>
							<canvas width="100" height="30" data-charty="statline" data-label="Line" data-labels="['a','b','c','d','e','f','g']" data-value="[43,48,52,58,50,95,100]" data-border-color="#fff"></canvas>
						</div>
					</div>
                </div>
            </div>
            <!-- END: statarea chart -->
			
            <!-- BEGIN: .row -->
            <div class="row">
                <div class="col-md-7">
					<!-- begin line chart -->
					<div class="box bg-pumpkin b-r-2">
						<div class="u-flex u-flexRow">
							<div class="u-sizeFill u-flex u-flexCol">
								<div class="u-sizeFill p-a-20">
									<div class="f-6 text-white text-right">
										<sup>$</sup><span class="counterup">1234</span>
										<div class="f-4">Weekly</div>
									</div>
								</div>
								<div class="p-a-20">
									<div class="progress is-xs m-a-0 m-t-15">
										<div class="progress-bar" role="progressbar" aria-valuenow="94" aria-valuemin="0" aria-valuemax="100" style="width: 43%;">
											<span class="sr-only">43% Complete</span>
										</div>
									</div>
									<div class="progress is-xs m-a-0 m-t-15">
										<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="94" aria-valuemin="0" aria-valuemax="100" style="width: 78%;">
											<span class="sr-only">78% Complete</span>
										</div>
									</div>
									<div class="progress is-xs m-a-0 m-t-15">
										<div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="94" aria-valuemin="0" aria-valuemax="100" style="width: 27%;">
											<span class="sr-only">27% Complete</span>
										</div>
									</div>
								</div>
							</div>
							<div class="u-sizeFill bg-orange p-a-10">
								<canvas width="100" height="100" data-charty="area" data-label="Area" data-labels="['Sun', 'Mon', 'Tur', 'Wed', 'Thu', 'Fri', 'Sat']" data-value="[10, 30, 20, 43, 57, 87, 43]" data-border-color="#fff" data-background-color="rgba(255, 255, 255, .5)" data-legend=true>
								</canvas>
							</div>
						</div>
					</div>
					<!-- END: line chart -->
                </div>
                <div class="col-md-5">
					<!-- begin usa vector map -->
					<div class="box">
						<div id="jmap-usa" style="height: 400px; width: 100%;"></div>
					</div>
					<!-- END: usa vector map -->
                </div>
            </div>
            <!-- END: .row -->
            <!-- BEGIN: .row -->
            <div class="row">
                <div class="col-sm-7">
					<div class="box">
						<header class="bg-primary">
							<h4>Last 10 Users</h4>
						</header>
                    <div class="box-body p-a-0 max-h-lg ps">
                      <table class="tablesorter table table-inverse ps">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>User</th>
                            <th>Name</th>
                            <th>E-mail</th>
                            <th>City</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>1</td>
                            <td>Bret</td>
                            <td>Leanne Graham</td>
                            <td>Sincere@april.biz</td>
                            <td>Gwenborough</td>
                          </tr>
                          <tr>
                            <td>2</td>
                            <td>Antonette</td>
                            <td>Ervin Howell</td>
                            <td>Shanna@melissa.tv</td>
                            <td>Wisokyburgh</td>
                          </tr>
                          <tr>
                            <td>3</td>
                            <td>Samantha</td>
                            <td>Clementine Bauch</td>
                            <td>Nathan@yesenia.net</td>
                            <td>McKenziehaven</td>
                          </tr>
                          <tr>
                            <td>4</td>
                            <td>Karianne</td>
                            <td>Patricia Lebsack</td>
                            <td>Julianne.OConner@kory.org</td>
                            <td>South Elvis</td>
                          </tr>
                          <tr>
                            <td>5</td>
                            <td>Kamren</td>
                            <td>Chelsey Dietrich</td>
                            <td>Lucio_Hettinger@annie.ca</td>
                            <td>Roscoeview</td>
                          </tr>
                          <tr>
                            <td>6</td>
                            <td>Leopoldo_Corkery</td>
                            <td>Mrs. Dennis Schulist</td>
                            <td>Karley_Dach@jasper.info</td>
                            <td>South Christy</td>
                          </tr>
                          <tr>
                            <td>7</td>
                            <td>Elwyn.Skiles</td>
                            <td>Kurtis Weissnat</td>
                            <td>Telly.Hoeger@billy.biz</td>
                            <td>Howemouth</td>
                          </tr>
                          <tr>
                            <td>8</td>
                            <td>Maxime_Nienow</td>
                            <td>Nicholas Runolfsdottir V</td>
                            <td>Sherwood@rosamond.me</td>
                            <td>Aliyaview</td>
                          </tr>
                          <tr>
                            <td>9</td>
                            <td>Delphine</td>
                            <td>Glenna Reichert</td>
                            <td>Chaim_McDermott@dana.io</td>
                            <td>Bartholomebury</td>
                          </tr>
                          <tr>
                            <td>10</td>
                            <td>Moriah.Stanton</td>
                            <td>Clementina DuBuque</td>
                            <td>Rey.Padberg@karina.biz</td>
                            <td>Lebsackbury</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>

                <div class="col-sm-5">
					<div class="box b-a">
						<header class="b-b">
							<h4>Todo</h4>
						</header>
						<div class="box-body p-a-0 max-h-lg ps">
							<ul class="todo-list is-order dragula">
								<li class="todo-item draggable handle ">
									<a href="#" class="todo-link">
										<i class="fa fa-fw fa-lg fa-square-o"></i>
									</a>
									<span class="todo-title">1 - delectus aut autem</span>
								</li>
								<!-- /.todo-item -->
								<li class="todo-item draggable handle ">
									<a href="#" class="todo-link">
										<i class="fa fa-fw fa-lg fa-square-o"></i>
									</a>
									<span class="todo-title">2 - quis ut nam facilis et officia qui</span>
								</li>
								<!-- /.todo-item -->
								<li class="todo-item draggable handle ">
									<a href="#" class="todo-link">
										<i class="fa fa-fw fa-lg fa-square-o"></i>
									</a>
									<span class="todo-title">3 - fugiat veniam minus</span>
								</li>
								<!-- /.todo-item -->
								<li class="todo-item draggable handle is-done">
									<a href="#" class="todo-link">
										<i class="fa fa-fw fa-lg fa-check-square"></i>
									</a>
									<span class="todo-title">4 - et porro tempora</span>
									</li>
								<!-- /.todo-item -->
								<li class="todo-item draggable handle ">
									<a href="#" class="todo-link">
										<i class="fa fa-fw fa-lg fa-square-o"></i>
									</a>
									<span class="todo-title">5 - laboriosam mollitia et enim quasi adipisci quia provident illum</span>
								</li>
								<!-- /.todo-item -->
								<li class="todo-item draggable handle ">
									<a href="#" class="todo-link">
										<i class="fa fa-fw fa-lg fa-square-o"></i>
									</a>
									<span class="todo-title">6 - qui ullam ratione quibusdam voluptatem quia omnis</span>
								</li>
								<!-- /.todo-item -->
								<li class="todo-item draggable handle ">
									<a href="#" class="todo-link">
										<i class="fa fa-fw fa-lg fa-square-o"></i>
									</a>
									<span class="todo-title">7 - illo expedita consequatur quia in</span>
								</li>
								<!-- /.todo-item -->
								<li class="todo-item draggable handle is-done">
									<a href="#" class="todo-link">
										<i class="fa fa-fw fa-lg fa-check-square"></i>
									</a>
									<span class="todo-title">8 - quo adipisci enim quam ut ab</span>
								</li>
								<!-- /.todo-item -->
								<li class="todo-item draggable handle ">
									<a href="#" class="todo-link">
										<i class="fa fa-fw fa-lg fa-square-o"></i>
									</a>
									<span class="todo-title">9 - molestiae perspiciatis ipsa</span>
								</li>
								<!-- /.todo-item -->
								<li class="todo-item draggable handle is-done">
									<a href="#" class="todo-link">
										<i class="fa fa-fw fa-lg fa-check-square"></i>
									</a>
									<span class="todo-title">10 - illo est ratione doloremque quia maiores aut</span>
								</li>
								<!-- /.todo-item -->
							</ul>
							<!-- /.todo-list -->
						</div>
						<!-- /.box-body -->
					</div>
					<!-- /.box -->
                </div>
             </div>
            <!-- END: .row -->
            <!-- BEGIN: .row -->
            <div class="row">
                <div class="col-sm-3">
					<div class="box shadow-2dp b-r-2">
						<header class="b-b">
							<h4 class="f-b"><i class="fa fa-fw fa-calendar-minus-o"></i>À receber:</h4>
							<!--<div class="box-tools">
								<span class="label label-success">5</span>
							</div>-->
						</header> 
						<div class="box-body">
							<ul class="members">		
								<!-- /.member -->
								<li class="member">
									<div class="member-info">
										<?php if (!empty($income)): ?>
											<?php foreach ($income as $incomeItem): ?>
												<?= $v->insert("views/balance", ["invoice" => $incomeItem->data()]); ?>
											<?php endforeach; ?>
										<?php else: ?>
											<div class="message success  fa fa-fw fa-check-square-o">
												No momento, não existem contas a receber.
											</div>
										<?php endif; ?>
										<div class="row">
											<div class="text-center f-n m-a-10">
												<a href="<?= url("work/receber"); ?>" title="Receitas">+ Receitas</a>
											</div>
										</div>
									</div>	
								</li>
								<!-- /.member -->
							</ul>
						</div>
					</div>
                </div>
				
				<div class="col-sm-3">
					<div class="box shadow-2dp b-r-2">
						<header class="b-b">
							<h4 class="f-b"><i class="fa fa-fw fa-calendar-check-o"></i>À pagar:</h4>
							<!--<div class="box-tools">
								<span class="label label-success">5</span>
							</div>-->
						</header> 
						<div class="box-body">
							<ul class="members">		
								<!-- /.member -->
								<li class="member">
									<div class="member-info">
										<?php if (!empty($expense)): ?>
											<?php foreach ($expense as $expenseItem): ?>
												<?= $v->insert("views/balance", ["invoice" => $expenseItem->data()]); ?>
											<?php endforeach; ?>
										<?php else: ?>
											<div class="message error  fa fa-fw fa-check-square-o">
												No momento, não existem contas a pagar.
											</div>
										<?php endif; ?>
										<div class="row">
											<div class="text-center f-n m-a-10">
												<a href="<?= url("work/pagar"); ?>" title="Despesas">+ Despesas</a>
											</div>
										</div>
									</div>	
								</li>
								<!-- /.member -->
							</ul>
						</div>
					</div>
                </div>
				
				
               <!-- <div class="col-sm-4">
					<div class="box shadow-2dp b-r-2">
						<header class="b-b">
							<h4>Tasks</h4>
							<div class="box-tools">
								<div class="dropdown">
									<a class="dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
										<span class="fa fa-fw fa-ellipsis-v text-muted"></span>
									</a>
									<ul class="dropdown-menu animated flipInY pull-right">
										<li>
											<a href="#">Add Task</a>
										</li>
										<li>
											<a href="#">Edit Task</a>
										</li>
										<li>
											<a href="#">Delete Task</a>
										</li>
									</ul>
								</div>
							</div>
						</header>
						<div class="box-body">
							<ul class="tasks">
								<li class="task">
									<div class="task-media bg-danger">
										<i class="fa fa-fw fa-plus"></i>
									</div>
									<div class="task-info">
										<a class="task-info-link" href="#">Mrs. Dennis Schulist</a>
											<span class="task-info-action">added new project</span>
										<a class="task-info-link" href="#">ola.org</a>
										<div class="task-info-time">
											<i class="fa fa-fw fa-clock-o"></i> <span data-momentum=relative>May 05, 2020</span>
										</div>
									</div>
								</li>
								<li class="task">
									<div class="task-media bg-success">
										<i class="fa fa-fw fa-minus"></i>
									</div>
									<div class="task-info">
										<a class="task-info-link" href="#">Kurtis Weissnat</a>
											<span class="task-info-action">added new project</span>
										<a class="task-info-link" href="#">elvis.io</a>
										<div class="task-info-time">
											<i class="fa fa-fw fa-clock-o"></i> <span data-momentum=relative>May 05, 2020</span>
										</div>
									</div>
								</li>
								<li class="task">
									<div class="task-media bg-danger">
										<i class="fa fa-fw fa-plus"></i>
									</div>
									<div class="task-info">
										<a class="task-info-link" href="#">Nicholas Runolfsdottir V</a>
											<span class="task-info-action">added new project</span>
										<a class="task-info-link" href="#">jacynthe.com</a>
										<div class="task-info-time">
											<i class="fa fa-fw fa-clock-o"></i> <span data-momentum=relative>May 05, 2020</span>
										</div>
									</div>
								</li>
						
								<li class="task">
									<div class="task-media bg-success">
										<i class="fa fa-fw fa-minus"></i>
									</div>
									<div class="task-info">
										<a class="task-info-link" href="#">Glenna Reichert</a>
											<span class="task-info-action">added new project</span>
										<a class="task-info-link" href="#">conrad.com</a>
										<div class="task-info-time">
											<i class="fa fa-fw fa-clock-o"></i> <span data-momentum=relative>May 05, 2020</span>
										</div>
									</div>
								</li>

								<li class="task">
									<div class="task-media bg-danger">
										<i class="fa fa-fw fa-plus"></i>
									</div>
									<div class="task-info">
										<a class="task-info-link" href="#">Clementina DuBuque</a>
											<span class="task-info-action">added new project</span>
										<a class="task-info-link" href="#">ambrose.net</a>
										<div class="task-info-time">
											<i class="fa fa-fw fa-clock-o"></i> <span data-momentum=relative>May 05, 2020</span>
										</div>
									</div>
								</li>
							</ul>
						</div>
					</div>
				</div>-->
				
				
				<!-- <div class="col-sm-4">
					<div class="box shadow-2dp">
						<header>
							<h4>Visitors <small class="text-muted">by city</small></h4>
						</header>
						<div class="box-body p-a-0">
							<nav class="list-group m-a-0">
								<a href="#" class="list-group-item b-r-0">
									Gwenborough
									<span class="pull-right">83%</span>
									<span class="list-group-progress" style="width: 29%;"></span>
								</a>
								<a href="#" class="list-group-item b-r-0">
									Wisokyburgh
									<span class="pull-right">82%</span>
									<span class="list-group-progress" style="width: 59%;"></span>
								</a>
								<a href="#" class="list-group-item b-r-0">
									McKenziehaven
									<span class="pull-right">43%</span>
									<span class="list-group-progress" style="width: 32%;"></span>
								</a>
								<a href="#" class="list-group-item b-r-0">
									South Elvis
									<span class="pull-right">48%</span>
									<span class="list-group-progress" style="width: 72%;"></span>
								</a>
								<a href="#" class="list-group-item b-r-0">
									Roscoeview
									<span class="pull-right">68%</span>
									<span class="list-group-progress" style="width: 55%;"></span>
								</a>
								<a href="#" class="list-group-item b-r-0">
									South Christy
									<span class="pull-right">88%</span>
									<span class="list-group-progress" style="width: 74%;"></span>
								</a>
								<a href="#" class="list-group-item b-r-0">
									Howemouth
									<span class="pull-right">35%</span>
									<span class="list-group-progress" style="width: 96%;"></span>
								</a>
								<a href="#" class="list-group-item b-r-0">
									Aliyaview
									<span class="pull-right">91%</span>
									<span class="list-group-progress" style="width: 99%;"></span>
								</a>
								<a href="#" class="list-group-item b-r-0">
									Bartholomebury
									<span class="pull-right">96%</span>
									<span class="list-group-progress" style="width: 14%;"></span>
								</a>
								<a href="#" class="list-group-item b-r-0">
									Lebsackbury
									<span class="pull-right">99%</span>
									<span class="list-group-progress" style="width: 54%;"></span>
								</a>
							</nav>
						</div>
					</div>
				</div>-->
				
			</div>
		<!-- END: .row -->
		</div>
	<!-- END: .container-fluid -->
	</div>
    <!-- END: .main-content -->
    <!-- begin .main-footer -->
    <footer class="main-footer bg-white p-a-5">
        main footer
    </footer>
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
                    minTickInterval: 1
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
                    $.post('<?= url("/app/dash");?>', function (callback) {
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
                            $(".app_wallet").removeClass("gradient-red gradient-green").addClass(callback.wallet.status);
                            $(".app_flex_amount").text("R$ " + callback.wallet.wallet);
                            $(".app_flex_balance .income").text("R$ " + callback.wallet.income);
                            $(".app_flex_balance .expense").text("R$ " + callback.wallet.expense);
                        }
                    }, "json");
                }, 200);
            });
        });
    </script>
<?php $v->end(); ?>