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

	$('td.breakdown.creature-spells').text(decklist['totals']['creatureSpells']);
	$('td.breakdown.noncreature-spells').text(decklist['totals']['noncreatureSpells']);
	$('td.breakdown.lands').text(decklist['totals']['lands']);

	var colors = ['white', 'blue', 'black', 'red', 'green', 'colorless'];

	for (var i = 0; i < colors.length; i++) {
		
		$('td.breakdown.'+colors[i]+'-symbols').text(decklist['totals']['mana'][colors[i]]['symbols']);
		$('td.breakdown.'+colors[i]+'-sources').text(decklist['totals']['mana'][colors[i]]['sources']);
	};

	for (var i = 0; i < decklist['totals']['drops'].length; i++) {
		
        manaCurveChart.series[0].data[i].update({
            y: decklist['totals']['drops'][i]
        }); 
	}
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

		lands: 0,

		mana: {					

			white: {

				symbols: 0,

				sources: 0
			},

			blue: {

				symbols: 0,

				sources: 0
			},

			black: {

				symbols: 0,

				sources: 0
			},

			red: {

				symbols: 0,

				sources: 0
			},

			green: {

				symbols: 0,

				sources: 0
			}, 

			colorless: {

				symbols: 0,

				sources: 0
			}
		},

		drops: [null, null, null, null, null, null, null, null] // for mana curve chart
	};

	var roles = ['md', 'sb'];

	for (var i = 0; i < roles.length; i++) {
		
		$('table#'+roles[i]+' tr.copy-row').each(function(index) {

			var copyRow = $(this);

			var card = {

				quantity: null,

				middleText: null,

				type: null,

				manaCost: null, 

				mana: {},

				id: null,

				actualCmc: null
			};

			card['quantity'] = Number(copyRow.find('td.quantity').text());

			decklistTotals[roles[i]] += card['quantity'];

			if (roles[i] == 'md') {

				card['middleText'] = copyRow.data('card-middle-text');

				card['type'] = getCardType(card['middleText']);

				decklistTotals[card['type']] += card['quantity'];

				card['manaCost'] = copyRow.find('td.card-mana-cost').html();

				card['id'] = copyRow.data('card-id');

				card['mana'] = getCardMana(card['manaCost'], card['type'], card['id']);

				for (var color in card['mana']) {

					for (var manaType in card['mana'][color]) {

						decklistTotals['mana'][color][manaType] += card['mana'][color][manaType] * card['quantity'];
					};
				};

				if (card['type'] != 'lands') {

					card['actualCmc'] = copyRow.data('card-actual-cmc');

					if (card['actualCmc'] == 'variable') {

						decklistTotals['drops'][7] += card['quantity'];

					} else {
						
						manaCurveChartIndex = card['actualCmc'] - 1; // array index

						if (manaCurveChartIndex > 6) {

							manaCurveChartIndex = 6;
						}

						decklistTotals['drops'][manaCurveChartIndex] += card['quantity'];
					}
				}
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

var getCardMana = function(manaCost, type, id) {

	var cardMana = {};

	if (type != 'lands') {

		var colors = {

			white: /mi\-w/g,

			blue: /mi\-u/g,

			black: /mi\-b/g,

			red: /mi\-r/g,

			green: /mi\-g/g,

			colorless: /mi\-c/g
		};

		for (var color in colors) {

			if (manaCost.match(colors[color]) === null) {

				var numOfSymbols = 0;
			}

			if (manaCost.match(colors[color]) !== null) {

				var numOfSymbols = manaCost.match(colors[color]).length;

				cardMana[color] = {

					symbols: numOfSymbols
				};
			}
		};
	}

	if (type == 'lands') {

		cardMana = getLandSources(id);
	}

	return cardMana;
}

var getLandSources = function(id) {

	var cardId = id;

	var cardMana = {

		white: {

			sources: 0
		},

		blue: {

			sources: 0
		},

		black: {

			sources: 0
		},

		red: {

			sources: 0
		},

		green: {

			sources: 0
		}, 

		colorless: {

			sources: 0
		}
	};

	if (cardId == 1063) { // Evolving Wilds

		cardMana = calculateSourcesForEvolvingWilds(cardMana);

		return cardMana;
	}

	for (var i = 0; i < lands.length; i++) {

		if (cardId == lands[i]['card_id']) {

			cardMana[lands[i]['color']]['sources'] += lands[i]['sources'];
		}
	};

	return cardMana;
}


/****************************************************************************************
VALIDATE DECKLIST
****************************************************************************************/

var validateDecklist = function() {

	var copyRows = $('tr.copy-row');

	var errorAlerts = [];

	var savedDecklistName = $('input#saved-decklist-name').val();

	if (savedDecklistName == '') {

		errorAlerts.push('Please enter a decklist name.');
	}

	var totalQuantityIsValid = validateTotalQuantity(copyRows);

	if (!totalQuantityIsValid) {

		errorAlerts.push('You have cards with more than 4 copies between main deck and sideboard.');
	}

	var decklistTotals = getDecklistTotals();

	if (decklistTotals['md'] < 60) {

		// errorAlerts.push('You have less than 60 main deck cards.');
	}	

	if (decklistTotals['sb'] > 15) {

		// errorAlerts.push('You have more than 15 sideboard cards.');
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
