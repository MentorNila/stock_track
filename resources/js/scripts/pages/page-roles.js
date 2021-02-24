/*=========================================================================================
    File Name: page-roles.js
    Description: Roles page
    --------------------------------------------------------------------------------------
==========================================================================================*/
$(document).ready(function () {

    $("#permissions").select2({
        dropdownAutoWidth: true,
        width: '100%'
    });

    $("#edit-permissions").select2({
        dropdownAutoWidth: true,
        width: '100%'
    });
    // variable declaration
    if ($("#roles-list-datatable").length > 0) {
        $("#roles-list-datatable").DataTable({
            responsive: true,
            'columnDefs': [
                {
                    "orderable": false,
                    "targets": [2]
                }]
        });
    }

    $('#editRole').on('show.bs.modal', function(e) {
        let id = $(e.relatedTarget).data('id');
        let $inputs = $('#editRoleForm :input');
        $.ajax({
            type: 'GET',
            data: {
                id: id,
            },
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: 'roles/get-role',
            success: function (response) {
                if(response.success == true){
                    let roleAttr = response.role;
                    $inputs.each(function() {

                        if ($(this).attr('name') in roleAttr){
                            if ($(this).attr('type') === 'checkbox'){
                                if (roleAttr[$(this).attr('name')] === 1){
                                    $(this).attr('checked', 'checked')
                                }else {
                                    $(this).removeAttr('checked')
                                }
                            } else {
                                $(this).val(roleAttr[$(this).attr('name')])
                            }
                        }
                    });

                }
            }
        });
        var url = 'roles/'+id;
        $('form#editRoleForm').attr('action', url);
    });
});
