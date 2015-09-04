$(document).ready(function() {

	/****************************************************************************************
	ADD CARD
	****************************************************************************************/


	$('a.add-card').on('click', function(e) {
		
		e.preventDefault();

		var card = {};

		var cardRow = $(this).closest('tr.card-row');

		card['id'] = cardRow.data('card-id');
		card['name'] = cardRow.data('card-name');
		card['actual-cmc'] = cardRow.data('card-actual-cmc');

		console.log(card);

		$("#decklist tbody").append('<tr><td>'+1+'</td><td>'+card['name']+'</td><td><a class="remove-card" href=""><div class="circle-minus-icon"><span class="glyphicon glyphicon-plus"></span></div></a></td></tr>');
	});

});