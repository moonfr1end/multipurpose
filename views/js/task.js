$(document).ready(function() {
	$('#producttable').dataTable({
		'processing': true,
		'serverSide': true,
		'iDisplayLength': 5,
		"pagingType": "simple",
		'bLengthChange': false,
		'bFilter': false,
		'ajax': {
			'url': mp_ajax + '?action=ptable'
		},
		'columns': [
			{'data': 'id_product'},
			{'data': 'name'},
			{'data': 'price'}
		]
	});
});