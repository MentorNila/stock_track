$(document).ready(function () {
    if ($(".activedate-picker").length > 0) {
        $('.activedate-picker').pickadate({
            format: 'yyyy-mm-dd'
        });
    }

    if ($(".expiredate-picker").length > 0) {
        $('.expiredate-picker').pickadate({
            format: 'yyyy-mm-dd '
        });
    }
});


$("#add-client-form").submit(function(e){

e.preventDefault();
var subdomain = $('#subdomain').val();
var id = $("#client_id").val();

//how to get id from form ......

$.ajax({
    type: 'GET',
    data: {
        subdomain: subdomain,
        id: id,
    },
    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    url: '/admin/clients/check-subdomain',
    success: function (response) {
        if(response.success == 'true'){
            $('.loginError').show();
        }else{
            $('#add-client-form').unbind().submit();
        }
    }
});

});




