CKEDITOR.plugins.add( 'levelthree', {
    icons: 'levelthree',
    init: function( editor ) {
        editor.addCommand( 'levelthree', {
            exec: function( editor ) {
                let selectedText = editor.getSelection().getSelectedText();
                tagType = 'text-block';
                levelOfTag = '3';
                if (selectedText !== "") {
                    let span = new CKEDITOR.dom.element("span");
                    span.setAttributes({id: 'selectedHtml'});
                    let sel = editor.getSelection();
                    let ranges = sel.getRanges();
                    for (var i = 0, len = ranges.length; i < len; ++i) {
                        span.append(ranges[i].cloneContents());
                    }
                    let html = span.$.innerHTML;
                    loadModal(levelOfTag, html);
                    activeSectionId = true;
                    taglevels = true;
                }
            }
        });
        editor.ui.addButton( 'levelthree', {
            label: 'Level 3',
            command: 'levelthree',
            toolbar: 'tagging'
        });
    }
});
