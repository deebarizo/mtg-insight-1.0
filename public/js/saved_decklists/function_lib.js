/****************************************************************************************
UPDATE DECKLIST
****************************************************************************************/

var updateDecklist = function(role, change) {

	var decklist = {};

	decklist['totals'] = getDecklistTotals();

	/****************************************************************************************
	UPDATE DECKLIST VIEW
	****************************************************************************************/

	$('span.decklist-totals.'+role).text(decklist['totals'][role]);

	console.log(decklist['totals']);
}


/****************************************************************************************
GET DECKLIST TOTALS
****************************************************************************************/

var getDecklistTotals = function() {

	var decklistTotals = {

		md: 0,
		
		sb: 0,

		creatureSpells: 0,

		noncreatureSpells: 0,

		lands: 0
	};

	var roles = ['md', 'sb'];

	for (var i = 0; i < roles.length; i++) {
		
		$('table#'+roles[i]+' tr.copy-row').each(function(index) {

			var copyRow = $(this);

			var card = {

				quantity: null,

				middleText: null,

				type: null
			};

			card['quantity'] = copyRow.find('td.quantity').text();

			decklistTotals[roles[i]] += Number(card['quantity']);

			if (roles[i] == 'md') {

				card['middleText'] = copyRow.data('card-middle-text');

				card['type'] = getCardType(card['middleText']);

				decklistTotals[card['type']] += Number(card['quantity']);
			}
		});	
	};

	return decklistTotals;	
}

var getCardType = function(middleText) {

	if (middleText.search('Land') > -1) {

		return 'lands'; // plural to match the property in decklistTotals object
	}

	if (middleText.search('Creature') > -1) {

		return 'creatureSpells';
	}

	return 'noncreatureSpells';
}


/****************************************************************************************
VALIDATE DECKLIST
****************************************************************************************/

var validateDecklist = function() {

	var copyRows = $('tr.copy-row');

	var errorAlerts = [];

	var totalQuantityIsValid = validateTotalQuantity(copyRows);

	if (!totalQuantityIsValid) {

		errorAlerts.push('You have cards with more than 4 copies between main deck and sideboard.');
	}

	var decklistTotals = getDecklistTotals();

	if (decklistTotals['md'] < 60) {

		errorAlerts.push('You have less than 60 main deck cards.');
	}	

	if (decklistTotals['sb'] > 15) {

		errorAlerts.push('You have more than 15 sideboard cards.');
	}		

	if (errorAlerts.length > 0) {

		showErrorAlerts(errorAlerts);

		return false;
	}

	return true;
}

var showErrorAlerts = function(errorAlerts) {

	for (var i = 0; i < errorAlerts.length; i++) {
		
		alert(errorAlerts[i]);
	};
}


/****************************************************************************************
TOTAL QUANTITY
****************************************************************************************/

var validateTotalQuantity = function(copyRows) {

	var totalQuantityIsValid = true;

	copyRows.each(function(index) {

		var card = {

			id: null,

			name: null,

			copyRows: null
		};

		card['id'] = $(this).data('card-id');

		card['name'] = $(this).data('card-name');

		card['copyRows'] = $('tr.copy-row[data-card-id="'+card['id']+'"]');
		
		var totalQuantity = getTotalQuantity(card['copyRows']);

		var cardIsBasicLand = isCardBasicLand(card['name']);

		if (totalQuantity > 4 && !cardIsBasicLand) {

			totalQuantityIsValid = false;

			return false;
		}
	});

	return totalQuantityIsValid;
}

var getTotalQuantity = function(cardCopyRows) {

	var totalQuantity = 0;

	cardCopyRows.each(function(index) {

		totalQuantity += Number($(this).find('td.quantity').text());
	});

	return totalQuantity;
}


/****************************************************************************************
QUANTITY
****************************************************************************************/

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
LAND
****************************************************************************************/

var isCardALand = function(card) {

	if (card['middle_text'].search('Land') > -1) {

		return true;
	}

	return false;
}

var isCardBasicLand = function(cardName) {

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

/****************************************************************************************
INSERT SPOT FOR COPY ROW
****************************************************************************************/

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

/****************************************************************************************
ROLE
****************************************************************************************/

var getRole = function(anchorTag) {

	if (anchorTag.hasClass('md')) {

		return 'md';
	}

	if (anchorTag.hasClass('sb')) {

		return 'sb';
	}
}
