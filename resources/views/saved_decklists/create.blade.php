@extends('master')

@section('content')

	<div class="row">
		<div class="col-lg-12">
			<h2>Saved Decklists</h2>
		</div>
	</div>


	<div class="row">
		
		<div class="col-lg-12">

			<h3>{{ $format }}</h3>

			<form class="form-inline" style="margin: 0 0 10px 0">

				<label>Actual CMCs</label>
				<select class="form-control actual-cmc-filter" style="width: 10%; margin-right: 20px">
				  	<option value="All">All</option>
				  	@foreach ($actualCmcs as $actualCmc)
					  	<option value="{{ $actualCmc }}">{{ $actualCmc }}</option>
				  	@endforeach
				</select>	

			</form>
		</div>
		
		<div class="col-lg-8">
			<table id="cards" class="table table-striped table-bordered table-hover table-condensed">
				<thead>
					<tr>
						<th>Name</th>
						<th>Mod</th>
						<th>Rating</th>
						<th>Actual CMC</th>
						<th>Mana Cost</th>
						<th>Add</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($cardsData as $card)
						<tr class="card-row" 
							data-card-id="{{ $card->id }}"
							data-card-name="{{ $card->name }}"
							data-card-actual-cmc="{{ $card->actual_cmc }}">
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
							<td>{!! $card->rating !!}</td>		
							<td>{!! $card->actual_cmc !!}</td>					
							<td>{!! $card->mana_cost !!}</td>
							<td>
								<a class="add-card" href="">
									<div class="circle-plus-icon">
										<span class="glyphicon glyphicon-plus"></span>
									</div>
								</a>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>

		<div class="col-lg-4">
			<h4 class="lineup">Decklist</h4>

			<table id="decklist" class="table table-striped table-bordered table-hover table-condensed">
				<thead>
					<tr>
						<th style="width: 10%">Q</th>					
						<th>Name</th>
						<th style="width: 10%">Remove</th>
					</tr>
				</thead>
				<tbody>

				</tbody>
			</table>

			<button style="width: 128px" class="btn btn-primary pull-right submit-decklist" type="submit">Submit Decklist</button>
		</div>

	</div>

	<script src="/js/cards/index.js"></script>

	<script src="/js/saved_decklists/create_and_edit.js"></script>

@stop