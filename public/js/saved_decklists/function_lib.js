/****************************************************************************************
UPDATE DECKLIST
****************************************************************************************/

var updateDecklist = function(role, change) {

	var decklistCount = getDecklistCount(role, change);

	$('span.decklist-count.'+role).text(decklistCount[role]);
}


/****************************************************************************************
VALIDATE DECKLIST
****************************************************************************************/

var validateDecklist = function(card, copyRow, role, change) {

	var errorAlerts = [];

	var totalQuantityIsValid = validateTotalQuantity(card, copyRow);

	if (!totalQuantityIsValid) {

		errorAlerts.push('You already have 4 copies between main deck and sideboard.');
	}

	var decklistCount = getDecklistCount(role, change);

	if (role == 'sb' && 
		change == 'add card' && 
		decklistCount[role] > 15) {

		errorAlerts.push('You reached the maximum sideboard limit of 15 cards.');
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
DECKLIST COUNT
****************************************************************************************/

var getDecklistCount = function(role, change) {

	var decklistCount = {

		md: 0,
		
		sb: 0
	};

	$('table#'+role+' td.quantity').each(function(index) {

		decklistCount[role] += Number($(this).text());
	});	

	if (change == 'add card') {

		decklistCount[role]++;
	}

	if (change == 'remove card') {

		decklistCount[role]--;
	}

	return decklistCount;	
}


/****************************************************************************************
TOTAL QUANTITY
****************************************************************************************/

var validateTotalQuantity = function(card, copyRow) {

	card['total_quantity'] = getTotalQuantity(copyRow);

	var cardIsBasicLand = isCardBasicLand(card);

	if (card['total_quantity'] > 4 && !cardIsBasicLand) {

		return false;
	}

	return true;
}

var getTotalQuantity = function(copyRow) {

	var totalQuantity = 0;

	copyRow.each(function(index) {

		totalQuantity += Number($(this).find('td.quantity').text());
	});

	totalQuantity++;

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

var isCardBasicLand = function(card) {

	if (card['name'] == 'Plains') {

		return true;
	}

	if (card['name'] == 'Island') {

		return true;
	}

	if (card['name'] == 'Swamp') {

		return true;
	}

	if (card['name'] == 'Mountain') {

		return true;
	}

	if (card['name'] == 'Forest') {

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
