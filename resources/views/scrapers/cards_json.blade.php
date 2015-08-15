@extends('master')

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<h2>Scrapers</h2>

			<h3>Cards JSON</h3>

			<hr>

			{!! Form::open() !!}
				<div class="form-group">
					{!! Form::label('set', 'Set') !!}
					{!! Form::select('set', array('L' => 'Large', 'S' => 'Small'), null, 
									['class' => 'form-control', 'style' => 'width: 30%']) !!}
				</div>
			{!! Form::close() !!}
		</div>
	</div>
@stop