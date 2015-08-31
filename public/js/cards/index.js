$(document).ready(function() {

	/****************************************************************************************
	DATA TABLE
	****************************************************************************************/

	$('#cards').dataTable({
		"scrollY": "600px",
		"paging": false,
		"order": [[2, "desc"]]
	});


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
	}

	function getFilter() {
		
		var actualCmc = $('select.actual-cmc-filter').val();

		filter = {

			actualCmc: actualCmc
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

		var cardRowActualCmc = $(cardRow).data('actual-cmc');

		if (cardRowActualCmc == actualCmc) {

			return;
		}

		$(cardRow).addClass('hide-card-row');
	}

});
