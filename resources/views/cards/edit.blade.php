@extends('master')

@section('content')

	<div class="row">
		<div class="col-lg-12">
			<h2>Cards</h2>
		</div>
	</div>


	<div class="row">
		
		<div class="col-lg-12">
			<h3>{{ $cardData->name }}</h3>

			@if(Session::has('message'))
				<div class="alert alert-{{ Session::get('alert') }} fade in" role="alert" style="width: 50%">
					<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
					{{ Session::get('message') }}
			    </div>
			@endif
		</div>

		<div class="col-lg-3">
			<img src="http://gatherer.wizards.com/Handlers/Image.ashx?multiverseid={{ $cardData->multiverseid }}&type=card">
		</div>

		<div class="col-lg-9">
			{!! Form::open(array('action' => ['CardsController@update', $cardData->id],'method' => 'PUT')) !!}
				<div class="form-group">
					{!! Form::label('actual_cmc', 'Actual CMC') !!}
					{!! Form::text('actual_cmc', null, ['class' => 'form-control', 'style' => 'width: 25%']) !!}

					{!! Form::submit('Submit', 
									['class' => 'form-control btn btn-primary', 'style' => 'width: 15%; margin-top: 20px']) !!}
				</div>
			{!! Form::close() !!}
		</div>

	</div>

@stop