/*=========================================================================================
    File Name: page-roles.js
    Description: Roles page
    --------------------------------------------------------------------------------------
==========================================================================================*/
$(document).ready(function () {
    // variable declaration
    if ($("#requests-list-datatable").length > 0) {
        $("#requests-list-datatable").DataTable({
            responsive: true,
            'columnDefs': [
                {
                    "orderable": false,
                    "targets": [7]
                }]
        });
    };
});
