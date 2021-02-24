/*=========================================================================================
    File Name: page-roles.js
    Description: Roles page
    --------------------------------------------------------------------------------------
==========================================================================================*/
$(document).ready(function () {
    // variable declaration
    if ($("#company-list-datatable").length > 0) {
        $("#company-list-datatable").DataTable({
            responsive: true,
            'columnDefs': [
                {
                    "orderable": false,
                    "targets": [6]
                }]
        });
    };
});
