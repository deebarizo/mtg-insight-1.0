$(document).ready(function() {

	/****************************************************************************************
	ADD CARD TO DECKLIST
	****************************************************************************************/

	$('a.add-card').on('click', function(e) {
		
		e.preventDefault();

		var card = {};

		var cardRow = $(this).closest('tr.card-row');

		card['id'] = cardRow.data('card-id');
		card['name'] = cardRow.data('card-name');
		card['actual-cmc'] = cardRow.data('card-actual-cmc');
		card['multiverseid'] = cardRow.data('card-multiverseid');

		var copyRow = $('tr.copy-row[data-card-id="'+card['id']+'"]');

		card['is-in-decklist'] = copyRow.length;

		if (card['is-in-decklist']) {

			card['quantity'] = getQuantity(copyRow);

			card['quantity']++;

			var cardIsBasicLand = isCardBasicLand(copyRow);

			if (card['quantity'] > 4 && !cardIsBasicLand) {

				return false;
			}

			copyRow.find('td.quantity').text(card['quantity']);
		
		} else if (!card['is-in-decklist']) {

			card['is-in-decklist'] = 1;

			card['quantity'] = 1;

			$("#decklist tbody").append('<tr class="copy-row" data-card-id="'+card['id']+'"><td class="quantity">'+card['quantity']+'<td class="card-name"><a class="card-name" target="_blank" href="/cards/'+card['id']+'">'+card['name']+'</a><div style="display: none" class="tool-tip-card-image"><img src="/files/card_images/'+card['multiverseid']+'.jpg"></div></td><td><a class="remove-card" href=""><div class="circle-minus-icon"><span class="glyphicon glyphicon-minus"></span></div></a></td></tr>');


			/****************************************************************************************
			TOOLTIPS FOR DYNAMIC CONTENT
			****************************************************************************************/

		    $('#decklist').on('mouseenter', 'a.card-name', function (event) {
		        
		        $(this).qtip({

		            content: {
		        
		                text: $(this).next('.tool-tip-card-image')
					},

					position: {

						my: 'bottom left',
						at: 'top right',
						target: $(this)
					},

		            overwrite: false, // Don't overwrite tooltips already bound

		            show: {
		            	
		                event: event.type, // Use the same event type as above
		                ready: true // Show immediately - important!
		            }
		        });
		    });
		}
	});


	/****************************************************************************************
	REMOVE CARD FROM DECKLIST
	****************************************************************************************/

	$('#decklist').on('click', 'a.remove-card', function(e) { // syntax for dynamic content

		e.preventDefault();

		var copyRow = $(this).closest('tr.copy-row');

		var card = {};

		card['quantity'] = getQuantity(copyRow);

		if (card['quantity'] == 1) {

			$(copyRow).remove();
		
		} else if (card['quantity'] != 1) {

			card['quantity']--;

			copyRow.find('td.quantity').text(card['quantity']);
		}
	});


	/****************************************************************************************
	FUNCTION LIBRARY
	****************************************************************************************/

	var getQuantity = function(copyRow) {
	
		var quantityTd = copyRow.find('td.quantity');
		
		return Number(quantityTd.text());
	}

	var isCardBasicLand = function(copyRow) {

		var cardName = copyRow.find('td.card-name').text();

		if (cardName == 'Plains') {

			return true;
		}

		if (cardName == 'Island') {

			return true;
		}

		if (cardName == 'Swamp') {

			return true;
		}

		if (cardName == 'Mountain') {

			return true;
		}

		if (cardName == 'Forest') {

			return true;
		}		

		return false;
	}

});