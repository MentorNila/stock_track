CKEDITOR.plugins.add( 'exhibitLink', {
    icons: 'exhibitLink',
    init: function( editor ) {
        editor.addCommand( 'exhibitLink', {
            exec: function( editor ) {
                $('#exhibitLinkModal').modal('toggle');
            }
        });
        editor.ui.addButton( 'exhibitLink', {
            label: 'Exhibit Link',
            command: 'exhibitLink',
            toolbar: 'checkboxes'
        });
    }
});
