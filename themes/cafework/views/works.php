<div class="balance">
    <p class="desc">
        <b class="cafecontrol_invoice_link transition">
            <a title=""
               href="">
                <?= $work->name; ?>
            </a></b>
		
		
		<b class="cafecontrol_invoice_link transition">
          
               
		
		</b>

		
		
        <?php
			$nowinitial = new DateTime();
			$dueinitial = new DateTime($work->date_initial);
			$expireinitial = $nowinitial->diff($dueinitial);
			$start = ($expireinitial->days == 1 ? "" : "start");

			if (!$expireinitial->days && $expireinitial->invert):?>
				<span class="date" style="color: var(--color-yellow);">Inicia Hoje</span>
			<?php elseif (!$expireinitial->invert): ?>
				<span class="date">Inicia em <?= ($expireinitial->days <= 1 ? "1 dia" : "{$expireinitial->days} dias") ?></span>
			<?php else: ?>
				<span class="date"
					style="color: var(--color-red);">Inicia Há <?= ($expireinitial->days <= 1 ? "1 dia" : "{$expireinitial->days} dias"); ?></span>
			<?php endif; ?>
		
		<?php
			$nowfinal = new DateTime($work->date_initial);
			$duefinal = new DateTime($work->date_final);
			$expirefinal = $nowfinal->diff($duefinal);
			$end = ($expirefinal->days == 1 ? "" : "end");

			if (!$expirefinal->days && $expirefinal->invert):?>
				<span class="date" style="color: var(--color-yellow);">Inicia Hoje</span>
			<?php elseif (!$expirefinal->invert): ?>
				<span class="date">Finaliza em <?= ($expirefinal->days <= 1 ? "1 dia" : "{$expirefinal->days} dias") ?></span>
			<?php else: ?>
				<span class="date"
					style="color: var(--color-red);">Finaliza Há <?= ($expirefinal->days <= 1 ? "1 dia" : "{$expirefinal->days} dias"); ?></span>
			<?php endif; ?>
	
    </p>
	
	<div class="box">
        <div class="box-body">
            <div class="progress is-xs">
                <div class="progress-bar" role="progressbar" aria-valuenow="23" aria-valuemin="0" aria-valuemax="100" style="width: 23%;">
                    <span class="sr-only">23%</span>
                </div>
            </div>
		</div>	
	</div>	
	
</div>


			