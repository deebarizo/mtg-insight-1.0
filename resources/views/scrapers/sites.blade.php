@extends('master')

@section('content')

	<div class="row">
		
		<div class="col-lg-12">
		
			<h3>Scrape Sites</h3>

		</div>

		<div class="col-lg-6">

			{!! Form::open(array('action' => ['ScrapersController@scrapeSites'], 'method' => 'POST')) !!}

				<div class="form-group">
					<label for="url">URL</label>
					<input class="form-control" name="url" type="text" id="url" value="http://www.mtggoldfish.com/">
				</div>

				<div class="form-group submit" style="width: 20%">		
					<input class="form-control btn btn-primary" type="submit" value="Submit">
				</div>

			{!! Form::close() !!}

		</div>

	</div>

@stop