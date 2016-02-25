@extends('master')

@section('content')

	<div class="row">
		
		<div class="col-lg-5">

			<h3>Cards</h3>

			<form class="form-inline" style="margin: 0 0 10px 0">

				<label>Actual CMCs</label>
				<select class="form-control actual-cmc-filter" style="width: 25%;">
				  	<option value="All">All</option>
				  	@foreach ($actualCmcs as $actualCmc)
					  	<option value="{{ $actualCmc }}">{{ $actualCmc }}</option>
				  	@endforeach
				</select>	

				<label>Type</label>
				<select class="form-control type-filter" style="width: 25%; margin-right: 20px">
				  	<option value="All">All</option>
				  	<option value="Land">Land</option>
				</select>	

			</form>

			<table style="font-size: 90%" id="cards" class="table table-striped table-bordered table-hover table-condensed">
				<thead>
					<tr>
						<th>Name</th>
						<th>R</th>
						<th>C</th>
						<th>MC</th>
						<th>Add</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($cardsData as $card)
						<tr class="card-row" 
							data-card-id="{{ $card->id }}"
							data-card-name="{{ $card->name }}"
							data-card-rating="{{ $card->rating }}"
							data-card-actual-cmc="{{ $card->actual_cmc }}"
							data-card-mana-cost="{{ $card->mana_cost }}"
							data-card-multiverseid="{{ $card->multiverseid }}"
							data-card-middle-text="{{ $card->middle_text }}">
							<td>
								<a class="card-name" target="_blank" href="/cards/{{ $card->id }}">{{ $card->name }}</a>
								<div style="display: none" class="tool-tip-card-image">
									<img src="/files/card_images/{{ $card->multiverseid }}.jpg">
								</div>
							</td>
							<td style="width: 10%">{{ $card->rating }}</td>		
							<td style="width: 10%">{{ $card->actual_cmc }}</td>					
							<td style="width: 20%">{!! $card->mana_cost !!}</td>
							<td style="width: 10%">
								<a class="add-card md" href="" style="margin-right: 5px">
									<div class="icon plus md">
										<span class="glyphicon glyphicon-plus"></span>
									</div>
								</a>
								<a class="add-card sb" href="">
									<div class="icon plus sb">
										<span class="glyphicon glyphicon-plus"></span>
									</div>
								</a>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>

		<div class="col-lg-7 decklist">
		
			<h3>Edit Decklist</h3>
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

		<div class="col-lg-5 decklist">

			<h4>Mana Curve</h4>

			<div id="mana-curve" style="height: 200px; margin: 0 auto;"></div>

			<h4>Main Deck (<span class="decklist-totals md">0</span>)</h4>

			<table id="md" style="font-size: 90%" class="table table-striped table-bordered table-hover table-condensed">
				
				<thead>
					<tr>
						<th style="width: 7%">Q</th>					
						<th>Name</th>
						<th style="width: 7%">R</th>
						<th style="width: 7%">C</th>
						<th style="width: 20%">MC</th>
						<th style="width: 7%">Rmv</th>
					</tr>
				</thead>
				
				<tbody>
					@if (!empty($savedDecklistVersion['md_copies']))
						@foreach ($savedDecklistVersion['md_copies'] as $copy)
							@include('saved_decklists._copy_row')
						@endforeach
					@endif
				</tbody>
			
			</table>

			<h4>Sideboard (<span class="decklist-totals sb">0</span>)</h4>

			<table id="sb" style="font-size: 90%" class="table table-striped table-bordered table-hover table-condensed">
				
				<thead>
					<tr>
						<th style="width: 7%">Q</th>					
						<th>Name</th>
						<th style="width: 7%">R</th>
						<th style="width: 7%">C</th>
						<th style="width: 20%">MC</th>
						<th style="width: 7%">Rmv</th>
					</tr>
				</thead>
				
				<tbody>
					@if (!empty($savedDecklistVersion['sb_copies']))
						@foreach ($savedDecklistVersion['sb_copies'] as $copy)
							@include('saved_decklists._copy_row')
						@endforeach
					@endif
				</tbody>
			
			</table>

			<button style="width: 128px" class="btn btn-primary pull-right edit-decklist" type="submit">Edit Decklist</button>
		
		</div>

		<div class="col-lg-2 breakdown">

			<h4>Breakdown</h4>

			<table style="font-size: 85%" class="table table-striped table-bordered table-hover table-condensed">
					
				<thead>
					<tr>
						<th>Type</th>
						<th style="width: 14%">Cards</th>					
					</tr>
				</thead>
				
				<tbody>
					<tr>
						<td>Creature Spells</td>
						<td class="breakdown creature-spells">0</td>					
					</tr>
					<tr>
						<td>Noncreature Spells</td>
						<td class="breakdown noncreature-spells">0</td>					
					</tr>
					<tr>
						<td>Lands</td>
						<td class="breakdown lands">0</td>					
					</tr>
				</tbody>
			
			</table>				

			<table style="font-size: 85%" class="table table-striped table-bordered table-hover table-condensed">
				
				<thead>
					<tr>
						<th>Color</th>
						<th>Mana Symbols</th>
						<th>Mana Sources</th>
					</tr>
				</thead>
				
				<tbody>
					<tr>
						<td><i class="mi mi-mana mi-shadow mi-w"></i></td>
						<td class="breakdown white-symbols">0</td>		
						<td class="breakdown white-sources">0</td>			
					</tr>
					<tr>
						<td><i class="mi mi-mana mi-shadow mi-u"></i></td>
						<td class="breakdown blue-symbols">0</td>		
						<td class="breakdown blue-sources">0</td>						
					</tr>
					<tr>
						<td><i class="mi mi-mana mi-shadow mi-b"></i></td>
						<td class="breakdown black-symbols">0</td>		
						<td class="breakdown black-sources">0</td>						
					</tr>
					<tr>
						<td><i class="mi mi-mana mi-shadow mi-r"></i></td>
						<td class="breakdown red-symbols">0</td>		
						<td class="breakdown red-sources">0</td>						
					</tr>
					<tr>
						<td><i class="mi mi-mana mi-shadow mi-g"></i></td>
						<td class="breakdown green-symbols">0</td>		
						<td class="breakdown green-sources">0</td>						
					</tr>
					<tr>
						<td><i class="mi mi-mana mi-shadow mi-c"></i></td>
						<td class="breakdown colorless-symbols">0</td>		
						<td class="breakdown colorless-sources">0</td>						
					</tr>
				</tbody>
			
			</table>

		</div>

	</div>

	<script type="text/javascript">

		/****************************************************************************************
		DATA TABLE
		****************************************************************************************/

		$('#cards').dataTable({
			"scrollY": "600px",
			"paging": false,
			"order": [[1, "desc"]]
		});

		/****************************************************************************************
		GLOBAL VARIABLES
		****************************************************************************************/	

		var lands = <?php echo $lands; ?>;

		$(function () {
		    $('#mana-curve').highcharts({
		        chart: {
		            type: 'column',
		            spacingLeft: 0,
		            spacingBottom: 0
		        },
		        xAxis: {
		            categories: [
		                '1',
		                '2',
		                '3',
		                '4',
		                '5',
		                '6',
		                '7+',
		                'var'
		            ],
		            title: {
		                text: 'Cost'
		            }
		        },
		        title: {
		        	text: null
		        },
		        yAxis: {
		            min: 0,
		            title: {
		                text: 'Number of Cards'
		            }
		        },
		        tooltip: {
		            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
		            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
		                '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
		            footerFormat: '</table>',
		            shared: true,
		            useHTML: true
		        },
		        plotOptions: {
		            column: {
		                pointPadding: 0.2,
		                borderWidth: 0,
		                dataLabels: {
		                    enabled: true
		                },
		                enableMouseTracking: false
		            }
		        },
		        series: [{
		            showInLegend: false,
		            data: [null, 11, 6, 7, 3, null, 2, 7]

		        }],
		        credits: false
		    });
		});

		var baseUrl = '<?php echo url(); ?>';

	</script>

	<script src="/js/cards/index.js"></script>

	<script src="/js/saved_decklists/function_lib_single_cards.js"></script>

	<script src="/js/saved_decklists/function_lib.js"></script>

	<script src="/js/saved_decklists/create_and_edit.js"></script>

	<script type="text/javascript">
		
		updateDecklist();

	</script>

@stop