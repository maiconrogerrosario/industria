<?php
	$nowinitial = new DateTime();
	$dueinitial = new DateTime($task->date_initial);
	$expireinitial = $nowinitial->diff($dueinitial);
	$start = ($expireinitial->days == 1 ? "" : "start");
	$nowfinal = new DateTime($task->date_initial);
	$duefinal = new DateTime($task->date_final);
	$expirefinal = $nowfinal->diff($duefinal);
	$end = ($expirefinal->days == 1 ? "" : "end");
	
	if (!$expireinitial->days && $expireinitial->invert):?>
		<div class="balance">
			<p class="desc">
				<b class="cafecontrol_invoice_link transition">
					<a title=""   href=""> <?= $task->task_name; ?></a>
				</b>
				<?php $work = $task->getWork(); ?>
				<b class="cafecontrol_invoice_link transition"><a title=""
					href="" class="date" style="color: var(--color-black);"><?= "Etapa:  {$task->stage_name}" ?></a>
				</b>
				<b class="cafecontrol_invoice_link transition"><a title=""
					href="" class="date" style="color: var(--color-black);"><?= "Obra:  {$work->name}" ?></a>
				</b>
				<span class="date" style="color: var(--color-yellow);">Inicia Hoje</span>
			</p>
		</div>	
	<?php elseif ($expireinitial->days == 30):?>
		<div class="balance">
			<p class="desc">
				<b class="cafecontrol_invoice_link transition">
					<a title=""   href=""> <?= $task->task_name; ?></a>
				</b>
				<?php $work = $task->getWork(); ?>
				<b class="cafecontrol_invoice_link transition"><a title=""
					href="" class="date" style="color: var(--color-black);"><?= "Etapa:  {$task->stage_name}" ?></a>
				</b>
				<b class="cafecontrol_invoice_link transition"><a title=""
					href="" class="date" style="color: var(--color-black);"><?= "Obra:  {$work->name}" ?></a>
				</b>
				<span class="date" style="color: var(--color-yellow);">Faltam  30 dias para iniciar a tarefa</span>
			</p>
		</div>
	<?php elseif ($expireinitial->days == 15): ?>
		<div class="balance">
			<p class="desc">
				<b class="cafecontrol_invoice_link transition">
					<a title=""   href=""> <?= $task->task_name; ?></a>
				</b>
				<?php $work = $task->getWork(); ?>
				<b class="cafecontrol_invoice_link transition"><a title=""
					href="" class="date" style="color: var(--color-black);"><?= "Etapa:  {$task->stage_name}" ?></a>
				</b>
				<b class="cafecontrol_invoice_link transition"><a title=""
					href="" class="date" style="color: var(--color-black);"><?= "Obra:  {$work->name}" ?></a>
				</b>
				<span class="date" style="color: var(--color-yellow);">Faltam 15 dias para iniciar a tarefa</span>
			</p>
		</div>
	<?php elseif ($expireinitial->days == 5): ?>
		<div class="balance">
			<p class="desc">
				<b class="cafecontrol_invoice_link transition">
					<a title=""   href=""> <?= $task->task_name; ?></a>
				</b>
				<?php $work = $task->getWork(); ?>
				<b class="cafecontrol_invoice_link transition"><a title=""
					href="" class="date" style="color: var(--color-black);"><?= "Etapa:  {$task->stage_name}" ?></a>
				</b>
				<b class="cafecontrol_invoice_link transition"><a title=""
					href="" class="date" style="color: var(--color-black);"><?= "Obra:  {$work->name}" ?></a>
				</b>
				<span class="date" style="color: var(--color-yellow);">Faltam  5 dias para iniciar a tarefa</span>
			</p>
		</div>
	<?php elseif ($expireinitial->days == 1): ?>
		<div class="balance">
			<p class="desc">
				<b class="cafecontrol_invoice_link transition">
					<a title=""   href=""> <?= $task->task_name; ?></a>
				</b>
				<?php $work = $task->getWork(); ?>
				<b class="cafecontrol_invoice_link transition"><a title=""
					href="" class="date" style="color: var(--color-black);"><?= "Etapa:  {$task->stage_name}" ?></a>
				</b>
				<b class="cafecontrol_invoice_link transition"><a title=""
					href="" class="date" style="color: var(--color-black);"><?= "Obra:  {$work->name}" ?></a>
				</b>
				<span class="date" style="color: var(--color-yellow);">Falta  1 dia para iniciar a tarefa</span>
			</p>
		</div>
	<?php endif; ?>