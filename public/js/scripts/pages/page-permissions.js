$(document).ready(function () {
    if ($("#permissions-list-datatable").length > 0) {
        $("#permissions-list-datatable").DataTable({
            responsive: true,
            'columnDefs': [
                {
                    "orderable": false,
                    "targets": [2]
                }]
        });
    }

    $('#editPermissions').on('show.bs.modal', function(e) {
        var title = $(e.relatedTarget).data('title');
        var url = $(e.relatedTarget).data('url');
        $(e.currentTarget).find('input[name="title"]').val(title);
        $(e.currentTarget).find( 'form' ).attr('action', url);
    });
});
