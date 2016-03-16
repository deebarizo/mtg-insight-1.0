@extends('master')

@section('content')

	<div class="row">

		@include('saved_decklists._cards_table')

		@include('saved_decklists._version')

	</div>

	@include('saved_decklists._scripts')

	<script type="text/javascript">
		
		updateDecklist();

	</script>

@stop