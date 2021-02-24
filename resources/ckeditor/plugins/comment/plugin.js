CKEDITOR.plugins.add( 'comment', {
    icons: 'comment',
    init: function( editor ) {
        editor.addCommand( 'addComment', {
            exec : function( editor ) {
                var selected_text = editor.getSelection().getSelectedText();
                var newElement = new CKEDITOR.dom.element("span");

                newElement.setAttributes({
                    class: 'comment',
                    'data-comment': 1
                })

                newElement.setText(selected_text);

                if (addComment()){
                    editor.insertElement(newElement);
                }

            }
        });

        editor.ui.addButton( 'comment', {
            label: 'Add Comment',
            command: 'addComment',
            toolbar: 'generating'
        });
    }
});

function addComment() {
    $('.new-comment').show();

    return true;
}
