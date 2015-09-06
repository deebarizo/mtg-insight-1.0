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

				var totalQuantityIsValid = validateTotalQuantity(copyRow, card);

				if (!totalQuantityIsValid) {

					return false;
				}

				card['quantity'] = getQuantity(copyRow, role, 'add card');

				copyRow.filter('.'+role).find('td.quantity').text(card['quantity']);

				updateDecklistCount(role);

				return false;
			}
		} 

		card['quantity'] = 1;

		var decklistHasCards = {

			md: null,

			sb: null
		}

		decklistHasCards[role] = $('table#'+role+' tr.copy-row').length;

		var copyRowHtml = '<tr class="copy-row '+role+'" data-card-id="'+card['id']+'" data-card-actual-cmc="'+card['actual_cmc']+'" data-card-middle-text="'+card['middle_text']+'"><td class="quantity">'+card['quantity']+'<td class="card-name"><a class="card-name" target="_blank" href="/cards/'+card['id']+'">'+card['name']+'</a><div style="display: none" class="tool-tip-card-image"><img src="/files/card_images/'+card['multiverseid']+'.jpg"></div></td><td>'+card['rating']+'</td><td>'+card['actual_cmc']+'</td><td>'+card['mana_cost']+'</td><td><a class="remove-card '+role+'" href=""><div class="icon minus"><span class="glyphicon glyphicon-minus"></span></div></a></td></tr>';

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

		updateDecklistCount(role);

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

			updateDecklistCount(role);

			return false;
		} 

		copyRow.find('td.quantity').text(card['quantity']);

		updateDecklistCount(role);
	});


	/****************************************************************************************
	FUNCTION LIBRARY (QUANTITY)
	****************************************************************************************/

	var getTotalQuantity = function(copyRow) {

		var totalQuantity = 0;

		copyRow.each(function(index) {

			totalQuantity += Number($(this).find('td.quantity').text());
		});

		totalQuantity++;

		return totalQuantity;
	}

	var validateTotalQuantity = function(copyRow, card) {

		card['total_quantity'] = getTotalQuantity(copyRow);

		var cardIsBasicLand = isCardBasicLand(copyRow);

		if (card['total_quantity'] > 4 && !cardIsBasicLand) {

			alert('You already have 4 copies between main deck and sideboard.');

			return false;
		}

		return true;
	}

	var getQuantity = function(copyRow, role, change) {

		var quantity = Number(copyRow.filter('.'+role).find('td.quantity').text());

		if (change == 'add card') {

			quantity++;
		}

		if (change == 'remove card') {

			quantity--;
		}

		return quantity;
	}


	/****************************************************************************************
	FUNCTION LIBRARY
	****************************************************************************************/

	var updateDecklistCount = function(role) {

		var count = 0;

		$('table#'+role+' td.quantity').each(function(index) {

			count += Number($(this).text());
		});

		$('span.count.'+role).text(count);
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

	var getInsertSpotForCopyRow = function(card, role) {

		var insertSpot = {

			spot: null,

			howToInsert: null
		};

		$('table#'+role+' tr.copy-row').each(function(index) {

			if (isCardALand(card)) {

				insertSpot['spot'] = $('table#'+role+' tr.copy-row').last();
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

			insertSpot['spot'] = $('table#'+role+' tr.copy-row').last();
			insertSpot['howToInsert'] = 'after';
		}

		return insertSpot;
	}

	var isCardALand = function(card) {

		if (card['middle_text'].search('Land') > -1) {

			return true;
		}

		return false;
	}

	var getRole = function(anchorTag) {

		if (anchorTag.hasClass('md')) {

			return 'md';
		}

		if (anchorTag.hasClass('sb')) {

			return 'sb';
		}
	}

});