@extends('master')

@section('content')

	<div class="row">
		
		<div class="col-lg-12">
		
			<h3>Create New Card</h3>

			@if (count($errors) > 0)
			    <div class="alert alert-danger fade in" role="alert">
					<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
			    	
			    	<p>Please try again.</p>

			        <ul>
			            @foreach ($errors->all() as $error)
			                <li>{{ $error }}</li>
			            @endforeach
			        </ul>
			    </div>
			@endif

			@if(Session::has('message'))
				<div class="alert alert-info fade in success-message" role="alert">
					<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
					{{ Session::get('message') }}
			    </div>
			@endif

		</div>

		<div class="col-lg-12">

			<style>
				div.form-group {
					width: 20%;
					float: left;
					margin-right: 30px;
				}

				div.form-group.note {
					width: 486px;
				}

				div.form-group.submit {
					width: 10%;
					margin-top: 30px;
				}
			</style>

			{!! Form::open(array('action' => ['CardsController@store'],'method' => 'POST', 'files' => true)) !!}

				<div class="form-group">
					<label for="set-code">Set Code</label>
					<select class="form-control" name="set-code" id="set-code">
						@foreach ($sets as $key => $set)
						  	<option value="{{ $set->code }}" <?php if ($key === 0) { echo 'selected="selected"'; } ?> >{{ $set->code }}</option>
						@endforeach
					</select>
				</div>

				<div class="form-group">
					<label for="name">Name</label>
					<input class="form-control" name="name" type="text" id="name">
				</div>

				<div class="form-group">
					<label for="mana-cost">Mana Cost (Syntax: {4}{B})</label>
					<input class="form-control" name="mana-cost" type="text" id="mana-cost">
				</div>

				<div class="form-group">
					<label for="mana-cost">CMC</label>
					<input class="form-control" name="cmc" type="number" id="cmc">
				</div>

				<div class="form-group">
					<label for="actual-cmc">Actual CMC</label>
					<input class="form-control" name="actual-cmc" type="text" value='same' id="actual-cmc">
				</div>

				<div class="form-group">
					<label for="rating">Rating (Required)</label>
					<input class="form-control" name="rating" type="number" id="rating">
				</div>	

				<div class="form-group note">
					<label for="note">Note</label>
					<textarea class="form-control" name="note" cols="50" rows="10" id="note"></textarea>
				</div>	

				<div class="form-group" style="clear: both">
					<label for="sources">Sources - Only for Lands (Syntax: green blue colorless)</label>
					<input class="form-control" name="sources" type="text" id="sources">
				</div>

				<div class="form-group">
					<label for="image">Image (Size: 223 x 311)</label>
					<input name="image" type="file" id="image">
				</div>

				<div class="form-group submit" style="clear: both">		
					<input class="form-control btn btn-primary" type="submit" value="Submit">
				</div>
		
			{!! Form::close() !!}
		
		</div>

	</div>

@stop