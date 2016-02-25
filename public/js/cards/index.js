$(document).ready(function() {

	/****************************************************************************************
	TOOLTIP (CARD IMAGE)
	****************************************************************************************/

	$('a.card-name').each(function() {

        $(this).qtip({
        
            content: {
        
                text: $(this).next('.tool-tip-card-image')
			},

			position: {

				my: 'bottom left',
				at: 'top right',
				target: $(this)
			}
        });
	});

	$('a.card-edit').each(function() {

        $(this).qtip({
        
            content: {
        
                text: $(this).next('.tool-tip-card-image')
			},

			position: {

				my: 'bottom left',
				at: 'top right',
				target: $(this)
			}
        });
	});


	/****************************************************************************************
	FILTER
	****************************************************************************************/

	var filter = {};

	function runFilter() {
		
		filter = getFilter();

		$('tr.card-row').removeClass('hide-card-row');

		runActualCmcFilter(filter);
		runTypeFilter(filter);
	}

	function getFilter() {
		
		var actualCmc = $('select.actual-cmc-filter').val();
		var type = $('select.type-filter').val();

		filter = {

			actualCmc: actualCmc,
			type: type
		};

		return filter;
	}


	/********************************************
	FILTER (ACTUAL CMC)
	********************************************/

	$('select.actual-cmc-filter').on('change', function() {

		runFilter();
	});

	function runActualCmcFilter(filter) {
		
		if (filter.actualCmc == 'All') {

			return;
		}

		$('tr.card-row').each(function() {

			var cardRow = $(this);

			hideActualCmcsNotSelected(cardRow, filter.actualCmc);
		});				
	}

	function hideActualCmcsNotSelected(cardRow, actualCmc) {

		var cardRowActualCmc = $(cardRow).data('card-actual-cmc');

		console.log(cardRowActualCmc);
		console.log(actualCmc);

		if (cardRowActualCmc == actualCmc) {

			return;
		}

		$(cardRow).addClass('hide-card-row');
	}

	/********************************************
	FILTER (TYPE)
	********************************************/

	$('select.type-filter').on('change', function() {

		runFilter();
	});

	function runTypeFilter(filter) {
		
		if (filter.type == 'All') {

			return;
		}

		$('tr.card-row').each(function() {

			var cardRow = $(this);

			hideTypeNotSelected(cardRow, filter.type);
		});				
	}

	function hideTypeNotSelected(cardRow, type) {

		var cardRowMiddleText = $(cardRow).data('card-middle-text');

		if (type == 'Nonland') {

			if (cardRowMiddleText.indexOf('Land') == -1) {

				return;
			}	
		}

		if (type == 'Land') {
			
			if (cardRowMiddleText.indexOf(type) > -1) {

				return;
			}
		}

		$(cardRow).addClass('hide-card-row');
	}

});
