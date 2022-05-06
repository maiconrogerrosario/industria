<div class="app_modal_box app_modal_<?= $type; ?>">
    <p class="title icon-calendar-check-o">Nova <?= ($type == 'income' ? "Receita" : "Despesa"); ?>:</p>
    <form class="form-horizontal" action="<?= url("/work/launch"); ?>" method="post">
        <input type="hidden" name="currency" value="BRL"/>
        <input type="hidden" name="type" value="<?= $type; ?>"/>

      
		<div class="form-group">

		<div class="col-md-6">
			<label for="description">Data de Entrega da Etapa:</label>
			<input type="text" id="description" name="description"  class="form-control"  placeholder="Ex: Aluguel" required/>
		</div>	
		
		</div>	
		
		
		<div class="form-group">
			<div class="col-md-6">
				<label for="value">Valor:</label>
				<input type="text" id="value" class="form-control mask-money" type="text" name="value" required/>
			</div>
				
			<div class="col-md-6">
				<label for="due_at">Data::</label>
				<input type="date" id="due_at" class="form-control"  type="date" name="due_at" required/>
			</div>			
		</div>
	
		<div class="form-group">
			<div class="col-md-12">
				<label for="wallet_id">Carteira:</label>
					<select name="wallet_id" id="wallet_id"   class="form-control">
						<?php foreach ($wallets as $wallet): ?>
                        <option value="<?= $wallet->id; ?>">&ofcir; <?= $wallet->wallet ?></option>
							<?php endforeach; ?>
					</select>
			</div>

			<div class="col-md-12">
				<label for="category_id">Categoria:</label>
					<select name="category_id"  id="category_id"   class="form-control">
						<?php foreach ($categories as $category): ?>
							<option value="<?= $category->id; ?>">&ofcir; <?= $category->name; ?></option>
						<?php endforeach; ?>
					</select>
			</div>
			
		</div>


        <div class="label_check">
            <p class="field icon-exchange">Repetição:</p>
            <label class="check"
                   data-checkbox="true"
                   data-slideup=".app_modal_<?= $type; ?> .repeate_item_fixed, .app_modal_<?= $type; ?> .repeate_item_enrollment">
                <input type="radio" name="repeat_when" value="single" checked> Única
            </label>

            <label data-checkbox="true"
                   data-slideup=".app_modal_<?= $type; ?> .repeate_item_enrollment"
                   data-slidedown=".app_modal_<?= $type; ?> .repeate_item_fixed">
                <input type="radio" name="repeat_when" value="fixed"> Fixa
            </label>

            <label data-checkbox="true"
                   data-slideup=".app_modal_<?= $type; ?> .repeate_item_fixed"
                   data-slidedown=".app_modal_<?= $type; ?> .repeate_item_enrollment">
                <input type="radio" name="repeat_when" value="enrollment"> Parcelada
            </label>
        </div>

        <label class="repeate_item repeate_item_fixed" style="display: none">
            <select name="period">
                <option value="month">&ofcir; Mensal</option>
                <option value="year">&ofcir; Anual</option>
            </select>
        </label>

        <label class="repeate_item repeate_item_enrollment" style="display: none">
            <input class="radius" type="number" value="1" min="1" max="420" placeholder="1 parcela" name="enrollments"/>
        </label>

        <button class="btn radius transition icon-check-square-o">
            Lançar <?= ($type == 'income' ? "Receita" : "Despesa"); ?></button>
    </form>
</div>