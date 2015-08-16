@extends('master')

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<h2>Scrapers</h2>

			<h3>Cards JSON</h3>

			@if(Session::has('message'))
				<div class="alert alert-{{ Session::get('alert') }} fade in" role="alert" style="width: 50%">
					<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
					{{ Session::get('message') }}
			    </div>
			@endif

			{!! Form::open(array('url' => 'scrapers/store_cards_json', 'files' => true)) !!}
				<div class="form-group">
					{!! Form::label('json_file', 'JSON File') !!}
					{!! Form::file('json_file') !!}

					{!! Form::submit('Submit', 
									['class' => 'form-control btn btn-primary', 'style' => 'width: 15%; margin-top: 20px']) !!}
				</div>
			{!! Form::close() !!}
		</div>
	</div>
@stop