<div class="col-lg-5">

	<h3>Cards</h3>

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