@extends('master')

@section('content')

	<div class="row">
		
		<div class="col-lg-12">

			<h3>Saved Decklists</h3>

			<table class="table table-striped table-bordered table-hover table-condensed">
	
				<thead>
					<tr>
						<th>Name</th>
						<th>Code</th>
						<th></th>
					</tr>
				</thead>
	
				<tbody>
					@foreach ($savedDecklists as $savedDecklist)
						<tr>
							<td>{{ $savedDecklist->name }}</td>
							<td>{{ $savedDecklist->code }}</td>
							<td><a href="/saved_decklist/{{ $savedDecklist->saved_decklist_id }}">Edit</a> | <a href="/solver_top_plays/{{ $playerPool->site_in_url }}/{{ $playerPool->sport_in_url }}/{{ $playerPool->time_period_in_url }}/{{ $playerPool->date }}/">Delete</a></td>
						</tr>
					@endforeach
				</tbody>
	
			</table>
	
		</div>
	
	</div>

@stop