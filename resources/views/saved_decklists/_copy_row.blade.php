<tr class="copy-row {{ $copy->role }}" data-card-quantity="{{ $copy->quantity }}" data-card-id="{{ $copy->card_id }}" data-card-role="{{ $copy->role }}" data-card-name="{{ $copy->name }}" data-card-actual-cmc="{{ $copy->actual_cmc }}" data-card-middle-text="{{ $copy->middle_text }}">
	<td class="quantity">{{ $copy->quantity }}</td>
	<td class="card-name">
		<a class="card-name" target="_blank" href="/cards/{{ $copy->card_id }}">{{ $copy->name }}</a>
		<div style="display: none" class="tool-tip-card-image"><img src="/files/card_images/{{ $copy->multiverseid }}.jpg"></div>
	</td>
	<td>{{ $copy->rating }}</td>
	<td>{{ $copy->actual_cmc }}</td>
	<td class="card-mana-cost">{!! $copy->mana_cost !!}</td>
	<td>
		<a class="remove-card {{ $copy->role }}" href="">
			<div class="icon minus">
				<span class="glyphicon glyphicon-minus"></span>
			</div>
		</a>
	</td>
</tr>