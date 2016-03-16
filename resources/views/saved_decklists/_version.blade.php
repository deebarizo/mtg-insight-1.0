<div class="col-lg-7 decklist">

	<h3>{{ $savedDecklistVersion['meta']->h3_tag }}</h3>
	<div class="form-inline">
		<label for="saved-decklist-name">Name</label>
		<input class="form-control" name="saved-decklist-name" type="text" value="{{ $savedDecklistVersion['meta']->name }}" id="saved-decklist-name" style="margin-right: 20px">
		<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
		<input type="hidden" name="saved-decklist-id" value="{{ $savedDecklistVersion['meta']->saved_decklist_id }}" id="saved-decklist-id">

		<label for="saved-decklist-latest-set-id">Latest Set</label>
		<select class="form-control" id="saved-decklist-latest-set-id">

			@foreach ($sets as $set)
			  	<option value="{{ $set['id'] }}" <?php if ($savedDecklistVersion['meta']->latest_set_id == $set['id']) { echo 'selected="selected"'; } ?> >{{ $set['code'] }}</option>
			@endforeach
		</select>
	</div>
</div>

<div class="col-lg-5 decklist">

	<h4>Mana Curve</h4>

	<div id="mana-curve" style="height: 200px; margin: 0 auto;"></div>

	<h4>Main Deck (<span class="decklist-totals md">0</span>)</h4>

	<table id="md" style="font-size: 90%" class="table table-striped table-bordered table-hover table-condensed">
		
		<thead>
			<tr>
				<th style="width: 7%">Q</th>					
				<th>Name</th>
				<th style="width: 7%">R</th>
				<th style="width: 7%">C</th>
				<th style="width: 20%">MC</th>
				<th style="width: 7%">Rmv</th>
			</tr>
		</thead>
		
		<tbody>
			@if (!empty($savedDecklistVersion['md_copies']))
				@foreach ($savedDecklistVersion['md_copies'] as $copy)
					@include('saved_decklists._copy_row')
				@endforeach
			@endif
		</tbody>
	
	</table>

	<h4>Sideboard (<span class="decklist-totals sb">0</span>)</h4>

	<table id="sb" style="font-size: 90%" class="table table-striped table-bordered table-hover table-condensed">
		
		<thead>
			<tr>
				<th style="width: 7%">Q</th>					
				<th>Name</th>
				<th style="width: 7%">R</th>
				<th style="width: 7%">C</th>
				<th style="width: 20%">MC</th>
				<th style="width: 7%">Rmv</th>
			</tr>
		</thead>
		
		<tbody>
			@if (!empty($savedDecklistVersion['sb_copies']))
				@foreach ($savedDecklistVersion['sb_copies'] as $copy)
					@include('saved_decklists._copy_row')
				@endforeach
			@endif
		</tbody>
	
	</table>

	<button style="width: 128px" class="btn btn-primary pull-right {{ $button['css_class'] }}" type="submit">{{ $button['anchor_text'] }}</button>

</div>

<div class="col-lg-2 breakdown">

	<h4>Breakdown</h4>

	<table style="font-size: 85%" class="table table-striped table-bordered table-hover table-condensed">
			
		<thead>
			<tr>
				<th>Type</th>
				<th style="width: 14%">Cards</th>					
			</tr>
		</thead>
		
		<tbody>
			<tr>
				<td>Creature Spells</td>
				<td class="breakdown creature-spells">0</td>					
			</tr>
			<tr>
				<td>Noncreature Spells</td>
				<td class="breakdown noncreature-spells">0</td>					
			</tr>
			<tr>
				<td>Lands</td>
				<td class="breakdown lands">0</td>					
			</tr>
		</tbody>
	
	</table>				

	<table style="font-size: 85%" class="table table-striped table-bordered table-hover table-condensed">
		
		<thead>
			<tr>
				<th>Color</th>
				<th>Mana Symbols</th>
				<th>Mana Sources</th>
			</tr>
		</thead>
		
		<tbody>
			<tr>
				<td><i class="mi mi-mana mi-shadow mi-w"></i></td>
				<td class="breakdown white-symbols">0</td>		
				<td class="breakdown white-sources">0</td>			
			</tr>
			<tr>
				<td><i class="mi mi-mana mi-shadow mi-u"></i></td>
				<td class="breakdown blue-symbols">0</td>		
				<td class="breakdown blue-sources">0</td>						
			</tr>
			<tr>
				<td><i class="mi mi-mana mi-shadow mi-b"></i></td>
				<td class="breakdown black-symbols">0</td>		
				<td class="breakdown black-sources">0</td>						
			</tr>
			<tr>
				<td><i class="mi mi-mana mi-shadow mi-r"></i></td>
				<td class="breakdown red-symbols">0</td>		
				<td class="breakdown red-sources">0</td>						
			</tr>
			<tr>
				<td><i class="mi mi-mana mi-shadow mi-g"></i></td>
				<td class="breakdown green-symbols">0</td>		
				<td class="breakdown green-sources">0</td>						
			</tr>
			<tr>
				<td><i class="mi mi-mana mi-shadow mi-c"></i></td>
				<td class="breakdown colorless-symbols">0</td>		
				<td class="breakdown colorless-sources">0</td>						
			</tr>
		</tbody>
	
	</table>

</div>