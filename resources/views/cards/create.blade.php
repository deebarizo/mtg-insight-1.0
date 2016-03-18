@extends('master')

@section('content')

	<div class="row">
		
		<div class="col-lg-12">
		
			<h3>Create New Card</h3>

		</div>

		<div class="col-lg-9">

			{!! Form::open() !!}

				<div class="form-group">
					<label for="set-code">Set Code</label>
					<select class="form-control" name="set-code" id="set-code" style="width: 25%">
						@foreach ($sets as $set)
						  	<option value="{{ $set->code }}" <?php if (LATEST_SET_CODE === $set->code) { echo 'selected="selected"'; } ?> >{{ $set->code }}</option>
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
					<label for="rating">Rating</label>
					<input class="form-control" style="width: 25%" name="rating" type="number" id="rating">
				</div>	

				<div class="form-group">
					<label for="note">Note</label>
					<textarea class="form-control" name="note" cols="50" rows="10" id="note"></textarea>
				</div>		
		
			{!! Form::close() !!}
		
		</div>

	</div>

@stop