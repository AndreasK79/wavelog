$(document).ready(function () {
	$("#header_quickswitch_table").DataTable({
		stateSave: true,
        searching: false,
        paging: false,
        ordering: false,
        info: false,
		language: {
			url: getDataTablesLanguageUrl(),
		},
	});
});

function set_active_location(current_active, new_active) {
    $.ajax({
        url: base_url + 'index.php/station/set_active/' + current_active + '/' + new_active + '/1',
        type: 'GET',
        success: function(response) {
            location.reload();
        }
    });
}