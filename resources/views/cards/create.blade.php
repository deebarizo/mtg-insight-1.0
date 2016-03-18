@extends('master')

@section('content')

	<div class="row">
		
		<div class="col-lg-12">
		
			<h3>Create New Card</h3>

			@if (count($errors) > 0)
			    <div class="alert alert-danger">
			    	<p>Please try again.</p>

			        <ul>
			            @foreach ($errors->all() as $error)
			                <li>{{ $error }}</li>
			            @endforeach
			        </ul>
			    </div>
			@endif

		</div>

		<div class="col-lg-9">

			{!! Form::open(array('action' => ['CardsController@store'],'method' => 'POST')) !!}

				<div class="form-group">
					<label for="set-code">Set Code</label>
					<select class="form-control" name="set-code" id="set-code" style="width: 25%">
						@foreach ($sets as $key => $set)
						  	<option value="{{ $set->code }}" <?php if ($key === 0) { echo 'selected="selected"'; } ?> >{{ $set->code }}</option>
						@endforeach
					</select>
				</div>

				<div class="form-group">
					<label for="name">Name</label>
					<input class="form-control" style="width: 25%" name="name" type="text" id="name">
				</div>

				<div class="form-group">
					<label for="mana-cost">Mana Cost</label>
					<input class="form-control" style="width: 25%" name="mana-cost" type="text" id="mana-cost">
				</div>

				<div class="form-group">
					<label for="mana-cost">CMC</label>
					<input class="form-control" style="width: 25%" name="cmc" type="number" id="cmc">
				</div>

				<div class="form-group">
					<label for="actual-cmc">Actual CMC</label>
					<input class="form-control" style="width: 25%" name="actual-cmc" type="text" value='same' id="actual-cmc">
				</div>

				<div class="form-group">
					<label for="rating">Rating</label>
					<input class="form-control" style="width: 25%" name="rating" type="number" id="rating">
				</div>		

				<div class="form-group">
					<label for="note">Note</label>
					<textarea class="form-control" name="note" cols="50" rows="10" id="note"></textarea>
				</div>		

				<div class="form-group">
					<label for="sources">Sources - Only for Lands (Syntax: green blue colorless)</label>
					<input class="form-control" style="width: 50%" name="sources" type="text" id="sources">
				</div>

				<div class="form-group">		
					<input class="form-control btn btn-primary" style="width: 15%" type="submit" value="Submit">
				</div>
		
			{!! Form::close() !!}
		
		</div>

	</div>

@stop