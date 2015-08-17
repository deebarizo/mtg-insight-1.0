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
		</div>

		<div class="col-lg-12">
			<table class="table table-striped table-bordered table-hover table-condensed">
				<thead>
					<tr>
						<th>Name</th>
						<th>Mana Cost</th>
						<th>Middle Text</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($cardsData as $card)
						<tr>
							<td><a target="_blank" href="/cards/{{ $card->id }}">{{ $card->name }}</a></td>
							<td>{!! $card->mana_cost !!}</td>
							<td>{{ $card->middle_text }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>

	</div>

@stop