@extends('master')

@section('content')

	<div class="row">
		
		<div class="col-lg-12">
		
			<h3>Create New Card</h3>

		</div>

		<div class="col-lg-12">

			{!! Form::open() !!}

				<select class="form-control" id="set-id">
		
					@foreach ($sets as $set)
					  	<option value="{{ $set->id }}" <?php if (LATEST_SET_ID === $set->id) { echo 'selected="selected"'; } ?> >{{ $set->code }}</option>
					@endforeach

				</select>
		
			{!! Form::close() !!}
		
		</div>

	</div>

@stop