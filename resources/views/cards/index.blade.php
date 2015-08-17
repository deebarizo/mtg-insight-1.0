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
						<th>Mod</th>
						<th>Mana Cost</th>
						<th>Middle Text</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($cardsData as $card)
						<tr>
							<td>
								<a target="_blank" href="/cards/{{ $card->id }}">{{ $card->name }}</a>
								<div style="display: none" class="tool-tip-card-image">
									<img src="http://gatherer.wizards.com/Handlers/Image.ashx?multiverseid={{ $card->multiverseid }}&type=card">
								</div>
							</td>
							<td>
								<a target="_blank" href="/cards/{{ $card->id }}/edit">
									<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
								</a>
							</td>							
							<td>{!! $card->mana_cost !!}</td>
							<td>{{ $card->middle_text }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>

	</div>

	<script>
	$(document).ready(function() {
	    $('a').each(function() {
	        $(this).qtip({
	            content: {
	                text: $(this).next('.tool-tip-card-image')
	            }
	        });
	    });
	 });

	</script>

@stop