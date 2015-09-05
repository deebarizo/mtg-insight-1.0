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

			var quantityTd = copyRow.find('td.quantity');
			card['quantity'] = Number(quantityTd.text());
			card['quantity']++;

			if (card['quantity'] > 4) {

				return false;
			}

			quantityTd.text(card['quantity']);
		
		} else if (card['is-in-decklist'] == false) {

			card['is-in-decklist'] = 1;

			card['quantity'] = 1;

			$("#decklist tbody").append('<tr class="copy-row" data-card-id="'+card['id']+'"><td class="quantity">'+card['quantity']+'<td class="card-name"><a class="card-name" target="_blank" href="/cards/'+card['id']+'" data-card-img="/files/card_images/'+card['multiverseid']+'.jpg">'+card['name']+'</a><div style="display: none" class="tool-tip-card-image"><img src="/files/card_images/'+card['multiverseid']+'.jpg"></div></td><td><a class="remove-card" href=""><div class="circle-minus-icon"><span class="glyphicon glyphicon-minus"></span></div></a></td></tr>');


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

});