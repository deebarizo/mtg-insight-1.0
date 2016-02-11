/****************************************************************************************
EVOLVING WILDS
****************************************************************************************/

var calculateSourcesForEvolvingWilds = function(cardMana) {

	$('tr.md td.card-name').each(function() {
		
		var cardName = $(this).text();

		if (cardName == 'Plains') {

			cardMana.white.sources++;
		}


		if (cardName == 'Forest') {

			cardMana.green.sources++;
		}


		if (cardName == 'Mountain') {

			cardMana.red.sources++;
		}


		if (cardName == 'Swamp') {

			cardMana.black.sources++;
		}


		if (cardName == 'Island') {

			cardMana.blue.sources++;
		}

		if (cardName == 'Wastes') {

			cardMana.colorless.sources++;
		}
	});

	return cardMana;
}