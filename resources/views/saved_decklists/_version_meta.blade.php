<div class="col-lg-7 decklist">

	<h3>{{ $savedDecklistVersion['meta']->h3_tag }}</h3>
	<div class="form-inline">
		<label for="saved-decklist-name">Name</label>
		<input class="form-control" name="saved-decklist-name" type="text" value="{{ $savedDecklistVersion['meta']->name }}" id="saved-decklist-name" style="margin-right: 20px">
		<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
		<input type="hidden" name="saved-decklist-id" value="{{ $savedDecklistVersion['meta']->saved_decklist_id }}" id="saved-decklist-id">

		<label for="saved-decklist-latest-set-id">Latest Set</label>
		<select class="form-control" id="saved-decklist-latest-set-id">

			@foreach ($sets as $set)
			  	<option value="{{ $set['id'] }}" <?php if ($savedDecklistVersion['meta']->latest_set_id == $set['id']) { echo 'selected="selected"'; } ?> >{{ $set['code'] }}</option>
			@endforeach
		</select>
	</div>
</div>