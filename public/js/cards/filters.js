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

		for (key in this) {

			if (typeof this[key] !== 'function') {

				var filter = this[key];

				if (filter.value === 'All') {

					// http://datatables.net/reference/api/column().search()
					cardsTable.column(filter.columnIndex).search('.*', true, false); 

					continue;
				}

				if (key === 'type' && filter.value === 'Nonland') {

					// http://stackoverflow.com/questions/1538512/how-can-i-invert-a-regular-expression-in-javascript
					cardsTable.column(filter.columnIndex).search('^(?!.*Land)', true, false); 

					continue;
				}

				if (key === 'actualCmc') {

					cardsTable.column(filter.columnIndex).search('^'+filter.value+'$', true, false); 

					continue;
				}

				cardsTable.column(filter.columnIndex).search(filter.value); 
			}
		}

		cardsTable.draw();
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