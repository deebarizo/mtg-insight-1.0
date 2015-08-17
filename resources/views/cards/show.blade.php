@extends('master')

@section('content')

	<div class="row">
		<div class="col-lg-12">
			<h2>Cards</h2>
		</div>
	</div>


	<div class="row">
		
		<div class="col-lg-12">
			<h3>{{ $cardData->name }} | <a href="/cards/{{ $cardData->id }}/edit">Edit</a></h3>
		</div>

		<div class="col-lg-3">
			<img src="http://gatherer.wizards.com/Handlers/Image.ashx?multiverseid={{ $cardData->multiverseid }}&type=card">
		</div>

		<div class="col-lg-3">
			<table class="table table-striped table-bordered table-hover table-condensed">
				<thead>
					<tr>
						<th>CMC</th>
						<th>Actual CMC</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>{{ $cardData->cmc }}</a></td>
						<td>{{ $cardData->actual_cmc }}</td>
					</tr>
				</tbody>
			</table>
		</div>

	</div>

@stop