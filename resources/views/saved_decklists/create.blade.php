@extends('master')

@section('content')

	<div class="row">
		
		<div class="col-lg-5">

			<h3>Cards</h3>

			<form class="form-inline" style="margin: 0 0 10px 0">

				<label>Actual CMCs</label>
				<select class="form-control actual-cmc-filter" style="width: 20%; margin-right: 20px">
				  	<option value="All">All</option>
				  	@foreach ($actualCmcs as $actualCmc)
					  	<option value="{{ $actualCmc }}">{{ $actualCmc }}</option>
				  	@endforeach
				</select>	

			</form>

			<table style="font-size: 90%" id="cards" class="table table-striped table-bordered table-hover table-condensed">
				<thead>
					<tr>
						<th>Name</th>
						<th>R</th>
						<th>C</th>
						<th>MC</th>
						<th>Add</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($cardsData as $card)
						<tr class="card-row" 
							data-card-id="{{ $card->id }}"
							data-card-name="{{ $card->name }}"
							data-card-rating="{{ $card->rating }}"
							data-card-actual-cmc="{{ $card->actual_cmc }}"
							data-card-mana-cost="{{ $card->mana_cost }}"
							data-card-multiverseid="{{ $card->multiverseid }}"
							data-card-middle-text="{{ $card->middle_text }}">
							<td>
								<a class="card-name" target="_blank" href="/cards/{{ $card->id }}">{{ $card->name }}</a>
								<div style="display: none" class="tool-tip-card-image">
									<img src="/files/card_images/{{ $card->multiverseid }}.jpg">
								</div>
							</td>
							<td style="width: 10%">{{ $card->rating }}</td>		
							<td style="width: 10%">{{ $card->actual_cmc }}</td>					
							<td style="width: 20%">{!! $card->mana_cost !!}</td>
							<td style="width: 12%">
								<a class="add-card md" href="">
									<div class="icon plus md">
										<span class="glyphicon glyphicon-plus"></span>
									</div>
								</a>
								&nbsp;
								<a class="add-card sb" href="">
									<div class="icon plus sb">
										<span class="glyphicon glyphicon-plus"></span>
									</div>
								</a>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>

		<div class="col-lg-5 decklist">
			<h3>New Decklist</h3>

			<h4>Breakdown</h4>

			<div class="col-lg-4" style="padding-left: 0">

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

			</div>

			<div class="col-lg-8">

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
							<td><i class="mtg mana-w"></i></td>
							<td class="breakdown white-symbols">0</td>		
							<td class="breakdown white-sources">0</td>			
						</tr>
						<tr>
							<td><i class="mtg mana-u"></i></td>
							<td class="breakdown blue-symbols">0</td>		
							<td class="breakdown blue-sources">0</td>						
						</tr>
						<tr>
							<td><i class="mtg mana-b"></i></td>
							<td class="breakdown black-symbols">0</td>		
							<td class="breakdown black-sources">0</td>						
						</tr>
						<tr>
							<td><i class="mtg mana-r"></i></td>
							<td class="breakdown red-symbols">0</td>		
							<td class="breakdown red-sources">0</td>						
						</tr>
						<tr>
							<td><i class="mtg mana-g"></i></td>
							<td class="breakdown green-symbols">0</td>		
							<td class="breakdown green-sources">0</td>						
						</tr>
					</tbody>
				
				</table>		

			</div>

			<h4>Main Deck (<span class="decklist-totals md">0</span>)</h4>

			<table id="md" class="table table-striped table-bordered table-hover table-condensed">
				
				<thead>
					<tr>
						<th style="width: 7%">Q</th>					
						<th>Name</th>
						<th style="width: 7%">R</th>
						<th style="width: 15%">C</th>
						<th style="width: 20%">MC</th>
						<th style="width: 7%">Rmv</th>
					</tr>
				</thead>
				
				<tbody>

				</tbody>
			
			</table>

			<h4>Sideboard (<span class="decklist-totals sb">0</span>)</h4>

			<table id="sb" class="table table-striped table-bordered table-hover table-condensed">
				
				<thead>
					<tr>
						<th style="width: 7%">Q</th>					
						<th>Name</th>
						<th style="width: 7%">R</th>
						<th style="width: 15%">aCMC</th>
						<th style="width: 20%">MC</th>
						<th style="width: 7%">Rmv</th>
					</tr>
				</thead>
				
				<tbody>

				</tbody>
			
			</table>

			<button style="width: 128px" class="btn btn-primary pull-right submit-decklist" type="submit">Submit Decklist</button>
		</div>

	</div>

	<script type="text/javascript">

		/****************************************************************************************
		DATA TABLE
		****************************************************************************************/

		$('#cards').dataTable({
			"scrollY": "600px",
			"paging": false,
			"order": [[1, "desc"]]
		});

		/****************************************************************************************
		GLOBAL VARIABLES
		****************************************************************************************/	

		var lands = <?php echo $lands; ?>;

	</script>

	<script src="/js/cards/index.js"></script>

	<script src="/js/saved_decklists/function_lib.js"></script>

	<script src="/js/saved_decklists/create_and_edit.js"></script>

@stop