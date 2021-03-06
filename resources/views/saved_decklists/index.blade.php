@extends('master')

@section('content')

	<div class="row">
		
		<div class="col-lg-8">

			<h3>Saved Decklists</h3>

			<h5><a href="/saved_decklists/create">Create New Decklist</a></h5>

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
							<td>
								<div class="form-group form-inline" style="margin-bottom: 0">
									<a href="/saved_decklists/{{ $savedDecklist->saved_decklist_id }}/edit"><button class="btn btn-primary btn-xs">Edit</button></a>  
									{!! Form::open(['method' => 'DELETE', 'route' => ['saved_decklists.destroy', $savedDecklist->saved_decklist_id], 'class' => 'submit-delete']) !!} 
										{!! Form::submit('Delete', ['class' => 'btn btn-danger btn-xs']) !!}
									{!! Form::close() !!}
								</div>
						</tr>
					@endforeach
				</tbody>
	
			</table>
	
		</div>
	
	</div>

@stop