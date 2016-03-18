@extends('master')

@section('content')

	<div class="row">
		
		<div class="col-lg-12">

			<h3>Cards</h3>

			<form class="form-inline" style="margin: 0 0 10px 0">

				<label>Actual CMCs</label>
				<select class="form-control actual-cmc-filter" style="width: 10%; margin-right: 20px">
				  	<option value="All">All</option>
				  	@foreach ($actualCmcs as $actualCmc)
					  	<option value="{{ $actualCmc }}">{{ $actualCmc }}</option>
				  	@endforeach
				</select>	

				<label>Type</label>
				<select class="form-control type-filter" style="width: 10%; margin-right: 20px">
				  	<option value="All">All</option>
				  	<option value="Nonland">Nonland</option>
				  	<option value="Land">Land</option>
				</select>	

			</form>
		</div>

		<div class="col-lg-12">
			<p><a href="cards/create">Create New Card</a></p>
		</div>
		
		<div class="col-lg-12">
			<table id="cards" class="table table-striped table-bordered table-hover table-condensed">
				<thead>
					<tr>
						<th>Name</th>
						<th>Mod</th>
						<th>Rating</th>
						<th class="actualCmc">Actual CMC</th>
						<th>Mana Cost</th>
						<th>Middle Text</th>
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
							<td>
								<a class="card-edit" target="_blank" href="/cards/{{ $card->id }}/edit">
									<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
								</a>
								<div style="display: none" class="tool-tip-card-image">
									<img src="/files/card_images/{{ $card->multiverseid }}.jpg">
								</div>
							</td>	
							<td>{{ $card->rating }}</td>		
							<td class="actualCmc">{{ $card->actual_cmc }}</td>					
							<td>{!! $card->mana_cost !!}</td>
							<td>{{ $card->middle_text }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>

	</div>

	<script src="/js/cards/data_table.js"></script>

	<script src="/js/cards/tooltips.js"></script>

	<script src="/js/cards/filters.js"></script>

@stop