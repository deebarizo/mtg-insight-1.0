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

		card['is-in-decklist'] = copyRow.length;

		if (card['is-in-decklist']) {

			card['quantity'] = getQuantity(copyRow);

			card['quantity']++;

			var cardIsBasicLand = isCardBasicLand(copyRow);

			if (card['quantity'] > 4 && !cardIsBasicLand) {

				return false;
			}

			copyRow.find('td.quantity').text(card['quantity']);

			return false;
		} 

		card['is-in-decklist'] = 1;

		card['quantity'] = 1;

		var decklistHasCards = $('tr.copy-row').length;

		var copyRowHtml = '<tr class="copy-row" data-card-id="'+card['id']+'" data-card-actual-cmc="'+card['actual_cmc']+'" data-card-middle-text="'+card['middle_text']+'"><td class="quantity">'+card['quantity']+'<td class="card-name"><a class="card-name" target="_blank" href="/cards/'+card['id']+'">'+card['name']+'</a><div style="display: none" class="tool-tip-card-image"><img src="/files/card_images/'+card['multiverseid']+'.jpg"></div></td><td>'+card['rating']+'</td><td>'+card['actual_cmc']+'</td><td>'+card['mana_cost']+'</td><td><a class="remove-card" href=""><div class="circle-minus-icon"><span class="glyphicon glyphicon-minus"></span></div></a></td></tr>';

		if (decklistHasCards) {

			var insertSpot = getInsertSpotForCopyRow(card);

			if (insertSpot['howToInsert'] == 'before') {

				insertSpot['spot'].before(copyRowHtml);
			}

			if (insertSpot['howToInsert'] == 'after') {

				insertSpot['spot'].after(copyRowHtml);
			}			
		}

		if (!decklistHasCards) {

			$("#decklist tbody").append(copyRowHtml);
		}


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

			return false;
		} 

		card['quantity']--;

		copyRow.find('td.quantity').text(card['quantity']);
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

	var getInsertSpotForCopyRow = function(card) {

		var insertSpot = {

			spot: null,

			howToInsert: null
		};

		$('tr.copy-row').each(function(index) {

			if (isCardALand(card)) {

				insertSpot['spot'] = $('tr.copy-row').last();
				insertSpot['howToInsert'] = 'after';

				return false;
			}

			var copyRow = {};

			copyRow['middle_text'] = $(this).data('card-middle-text');

			if (isCardALand(copyRow)) {

				insertSpot['spot'] = $(this);
				insertSpot['howToInsert'] = 'before';

				return false;
			}

			copyRow['actual_cmc'] = $(this).data('card-actual-cmc');

			if (copyRow['actual_cmc'] == 'variable') {

				copyRow['actual_cmc'] = 100;
			}

			if (card['actual_cmc'] == 'variable') {

				card['actual_cmc'] = 100;
			}

			if (copyRow['actual_cmc'] > card['actual_cmc']) {

				insertSpot['spot'] = $(this);
				insertSpot['howToInsert'] = 'before';

				return false;
			}
		});

		if (insertSpot['spot'] === null) {

			insertSpot['spot'] = $('tr.copy-row').last();
			insertSpot['howToInsert'] = 'after';
		}

		return insertSpot;
	}

	var isCardALand =  function(card) {

		if (card['middle_text'].search('Land') > -1) {

			return true;
		}

		return false;
	}

});