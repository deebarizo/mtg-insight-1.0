@extends('master')

@section('content')

	<div class="row">
		
		<div class="col-lg-12">

			<h3>{{ $cardData->name }} | <a href="/cards/{{ $cardData->id }}/edit">Edit</a></h3>

			@if(Session::has('message'))
				<div class="alert alert-{{ Session::get('alert') }} fade in" role="alert" style="width: 50%">
					<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
					{{ Session::get('message') }}
			    </div>
			@endif
		
		</div>

		<div class="col-lg-3">
			<img src="/files/card_images/{{ $cardData->multiverseid }}.jpg">
		</div>

		<div class="col-lg-6">

			<table class="table table-striped table-bordered table-hover table-condensed">
				<thead>
					<tr>
						<th>CMC</th>
						<th>Actual CMC</th>
						<th>Rating</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>{{ $cardData->cmc }}</a></td>
						<td>{{ $cardData->actual_cmc }}</td>
						<td>{{ $cardData->rating }}</td>
					</tr>
				</tbody>
			</table>

			<table class="table table-striped table-bordered table-hover table-condensed">
				<thead>
					<tr>
						<th>Note</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>{{ $cardData->note }}&nbsp;</a></td>
					</tr>
				</tbody>
			</table>
		
		</div>

	</div>

@stop