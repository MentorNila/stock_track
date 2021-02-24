CKEDITOR.plugins.add( 'users', {
    icons: 'users',
    init: function( editor ) {
        editor.addCommand( 'users', {
            exec: function( editor ) {
                $.ajax({
                    type: 'GET',
                    data: {
                        filingId: filingID
                    },
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: '/editor/data/get-user-filing',
                    success: function (response) {
                        if (response.success == true){
                            if (response.content !== ''){
                                $('#users').html(response.content)
                            }

                            $('#usersModal').modal('toggle');

                        }
                    }
                });
            }
        });
        editor.ui.addButton( 'users', {
            label: 'Assign Users',
            command: 'users',
            toolbar: 'generating'
        });
    }
});
