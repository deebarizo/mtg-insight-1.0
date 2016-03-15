$(document).ready(function() {

	/****************************************************************************************
	FILTERS
	****************************************************************************************/

	function FilterGroup(actualCmc, type) {

		this.actualCmc = {

			value: actualCmc,
			columnIndex: 3
		};

		this.type = {

			value: type,
			columnIndex: 5
		};
	} 

	FilterGroup.prototype.execute = function() {
		
		$('tr.card-row').removeClass('hide-card-row');

		for (key in this) {

			if (typeof this[key] !== 'function') {

				var filter = this[key];

				if (filter.value === 'All') {

					continue;
				}

				if (filter.value === 'Nonland') {

					filter.value = 
				}

				$('tr.card-row').each(function() {

					var cardRow = $(this);

					oTable.fnFilter(filter.value, filter.columnIndex);
				});
			}
		}
	};

	/********************************************
	EXECUTE
	********************************************/	

	var selectCssClasses = ['actual-cmc-filter', 'type-filter'];

	for (var i = 0; i < selectCssClasses.length; i++) {
		
		$('select.'+selectCssClasses[i]).on('change', function() {

			var actualCmc = $('select.actual-cmc-filter').val();
			var type = $('select.type-filter').val();

			filterGroup = new FilterGroup(actualCmc, type);

			filterGroup.execute();
		});
	}




});
