/*=========================================================================================
    File Name: page-roles.js
    Description: Roles page
    --------------------------------------------------------------------------------------
==========================================================================================*/
$(document).ready(function () {
    // variable declaration
    if ($("#plans-list-datatable").length > 0) {
        $("#plans-list-datatable").DataTable({
            "order": [[ 0, "desc" ]],
            responsive: true,
            'columnDefs': [
                {
                    "orderable": false,
                    "targets": [3]
                }]
        });
    };
});
