@extends('master')

@section('content')

	<div class="row">
		<div class="col-lg-12">
			<h2>Cards</h2>
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
					  	<option value="{{ $actualCmc['cmc'] }}">{{ $actualCmc['cmc'] }}</option>
				  	@endforeach
				</select>	

			</form>
		</div>
		
		<div class="col-lg-12">
			<table id="cards" class="table table-striped table-bordered table-hover table-condensed">
				<thead>
					<tr>
						<th>Name</th>
						<th>Mod</th>
						<th>Actual CMC</th>
						<th>Mana Cost</th>
						<th>Middle Text</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($cardsData as $card)
						<tr class="card-row" data-actual-cmc="{{ $card->actual_cmc }}">
							<td>
								<a class="card-name" target="_blank" href="/cards/{{ $card->id }}">{{ $card->name }}</a>
								<div style="display: none" class="tool-tip-card-image">
									<!-- <img src="http://gatherer.wizards.com/Handlers/Image.ashx?multiverseid={{ $card->multiverseid }}&type=card"> -->
								</div>
							</td>
							<td>
								<a target="_blank" href="/cards/{{ $card->id }}/edit">
									<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
								</a>
							</td>		
							<td>{!! $card->actual_cmc !!}</td>					
							<td>{!! $card->mana_cost !!}</td>
							<td>{{ $card->middle_text }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>

	</div>

	<script src="/js/cards/index.js"></script>

@stop