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
		card['rating'] = cardRow.data('card-rating');
		card['actual_cmc'] = cardRow.data('card-actual-cmc');
		card['mana_cost'] = cardRow.data('card-mana-cost');
		card['multiverseid'] = cardRow.data('card-multiverseid');
		card['middle_text'] = cardRow.data('card-middle-text');

		var copyRow = $('tr.copy-row[data-card-id="'+card['id']+'"]');

		var role = getRole($(this));

		card['rows-in-decklist'] = copyRow.length; // 0 = not in decklist, 1 = in md OR sb but not BOTH, 2 = in md AND sb

		if (card['rows-in-decklist'] > 0) {

			var roleMatchesCopyRow = copyRow.filter('.'+role).length; 

			if (roleMatchesCopyRow) {

				card['quantity'] = getQuantity(copyRow, role, 'add card');

				copyRow.filter('.'+role).find('td.quantity').text(card['quantity']);
				copyRow.filter('.'+role).attr('data-card-quantity', card['quantity']);

				updateDecklist(role, 'add card');

				return false;
			}
		} 

		card['quantity'] = 1;

		var decklistHasCards = {

			md: null,

			sb: null
		}

		decklistHasCards[role] = $('table#'+role+' tr.copy-row').length;

		var copyRowHtml = '<tr class="copy-row '+role+'" data-card-quantity="'+card['quantity']+'" data-card-id="'+card['id']+'" data-card-name="'+card['name']+'" data-card-actual-cmc="'+card['actual_cmc']+'" data-card-middle-text="'+card['middle_text']+'"><td class="quantity">'+card['quantity']+'<td class="card-name"><a class="card-name" target="_blank" href="/cards/'+card['id']+'">'+card['name']+'</a><div style="display: none" class="tool-tip-card-image"><img src="/files/card_images/'+card['multiverseid']+'.jpg"></div></td><td>'+card['rating']+'</td><td>'+card['actual_cmc']+'</td><td class="card-mana-cost">'+card['mana_cost']+'</td><td><a class="remove-card '+role+'" href=""><div class="icon minus"><span class="glyphicon glyphicon-minus"></span></div></a></td></tr>';

		if (decklistHasCards[role]) {

			var insertSpot = getInsertSpotForCopyRow(card, role);

			if (insertSpot['howToInsert'] == 'before') {

				insertSpot['spot'].before(copyRowHtml);
			}

			if (insertSpot['howToInsert'] == 'after') {

				insertSpot['spot'].after(copyRowHtml);
			}			
		}

		if (!decklistHasCards[role]) {

			$('table#'+role+' tbody').append(copyRowHtml);
		}

		updateDecklist(role, 'add card');

		/****************************************************************************************
		TOOLTIPS FOR DYNAMIC CONTENT
		****************************************************************************************/

	    $('#md').on('mouseenter', 'a.card-name', function (event) {
	        
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
	});


	/****************************************************************************************
	REMOVE CARD FROM DECKLIST
	****************************************************************************************/

	$('div.decklist').on('click', 'a.remove-card', function(e) { // syntax for dynamic content

		e.preventDefault();

		var copyRow = $(this).closest('tr.copy-row');

		var card = {};

		var role = getRole($(this));

		card['quantity'] = getQuantity(copyRow, role, 'remove card');

		if (card['quantity'] == 0) {

			$(copyRow).remove();

			updateDecklist(role, 'remove card');

			return false;
		} 

		copyRow.find('td.quantity').text(card['quantity']);
		copyRow.attr('data-card-quantity', card['quantity']);

		updateDecklist(role, 'remove card');
	});


	/****************************************************************************************
	SUBMIT DECKLIST
	****************************************************************************************/

	$('button.submit-decklist').on('click', function() {

		var decklistIsValid = validateDecklist();

		if (!decklistIsValid) {

			return false;
		}

		console.log('Decklist was successfully submitted.');
	});

});
