CKEDITOR.plugins.add( 'checked', {
    icons: 'checked',
    init: function( editor ) {
        editor.addCommand( 'check', {
            exec: function( editor ) {
                editor.insertHtml("☒");
            }
        });
        editor.ui.addButton( 'checked', {
            label: 'Check Button',
            command: 'check',
            toolbar: 'checkboxes'
        });
    }
});
