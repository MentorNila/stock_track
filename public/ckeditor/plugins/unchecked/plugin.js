CKEDITOR.plugins.add( 'unchecked', {
    icons: 'unchecked',
    init: function( editor ) {
        editor.addCommand( 'uncheck', {
            exec: function( editor ) {
                editor.insertHtml("☐");
            }
        });
        editor.ui.addButton( 'unchecked', {
            label: 'Uncheck Button',
            command: 'uncheck',
            toolbar: 'checkboxes'
        });
    }
});
