@extends('master')

@section('content')

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
		
		<div class="col-lg-12">
			<table id="cards" class="table table-striped table-bordered table-hover table-condensed">
				<thead>
					<tr>
						<th>Name</th>
						<th>Mod</th>
						<th>Rating</th>
						<th>Actual CMC</th>
						<th>Mana Cost</th>
						<th>Middle Text</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($cardsData as $card)
						<tr class="card-row" 
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
							<td>{{ $card->middle_text }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>

	</div>

	<script type="text/javascript">

		/****************************************************************************************
		DATA TABLE
		****************************************************************************************/

		$('#cards').dataTable({
			"scrollY": "600px",
			"paging": false,
			"order": [[2, "desc"]]
		});

	</script>

	<script src="/js/cards/index.js"></script>

@stop